<?php
namespace database;

use PDO;
use database\DB;

class Migration
{
  private $db;
  private $migrationsPath;

  public function __construct()
  {
    $this->db = DB::get();

    $this->db->exec("CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        run_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    )");

    $this->migrationsPath = __DIR__ . '/migrations';
  }

  public function migrate(): array{

    $executedMigrations = $this->db->query("SELECT migration FROM migrations")->fetchAll(PDO::FETCH_COLUMN);

    $migrationFiles = scandir($this->migrationsPath);

    $messages = [];
    $errors = [];

    foreach ($migrationFiles as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php' && !in_array($file, $executedMigrations)) {
          require_once $this->migrationsPath . '/' . $file;

          try 
          {
            $className = $this->getClassNameFromMigrationFile($file);
            $class = new $className();

            $query = $class->up();
            $this->db->exec($query);

            $stmt = $this->db->prepare("INSERT INTO migrations (migration, run_at) VALUES (?, NOW())");
            $stmt->execute([$file]);

            $messages[] = "Migration $file executed successfully.";
          } catch (\Exception $e) {
            $errors[] = "Failed to execute migration $file: " . $e->getMessage();
          }
        }
    }

    if(!$migrationFiles || count($migrationFiles) == 0)
    {
      return [true, 200, null, "No new migrations found."];
    }

    if(count($errors) > 0)
    {
      return [false, 500, [$messages, $errors], null];
    }
    else
    {
      return [true, 200, [$messages, $errors], null];
    }
  }

  public function rollback(): array
  {
    $lastMigration = $this->db->query("SELECT * FROM migrations ORDER BY id DESC LIMIT 1")->fetch();
    if($lastMigration)
    {
      $query = $this->db->prepare("SELECT id, migration FROM migrations WHERE MINUTE(run_at) = MINUTE(?)");
      $query->execute([$lastMigration['run_at']]);
      $lastMinuteMigrations = $query->fetchAll(PDO::FETCH_ASSOC); // get all the migrations that ran at the same last minute

      $migrationFiles = scandir($this->migrationsPath);

      $messages = [];
      $errors = [];

      $migrationsIds = array_column($lastMinuteMigrations, 'id');
      $migrationsNames = array_column($lastMinuteMigrations, 'migration');

      foreach ($migrationFiles as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'php' && in_array($file, $migrationsNames)) {
          require_once $this->migrationsPath . '/' . $file;

          try {
            $className = $this->getClassNameFromMigrationFile($file);
            $class = new $className();
            
            $query = $class->down();
            $this->db->exec($query);

            $idsPlaceholders = implode(',', array_fill(0, count($migrationsIds), '?'));

            $stmt = $this->db->prepare("DELETE FROM migrations WHERE id IN ($idsPlaceholders)");
            $stmt->execute($migrationsIds);

            $messages[] = "Rollback Migration $file executed successfully.";
          } catch (\Exception $e) {
            $errors[] = "Failed to execute rollback $file: " . $e->getMessage();
          }
        }
      }

      if(!$migrationFiles || count($migrationFiles) == 0)
      {
        return [true, 200, null, "No migrations found to rollback."];
      }

      if(count($errors) > 0)
      {
        return [false, 500, [$messages, $errors], null];
      }
      else
      {
        return [true, 200, [$messages, $errors], null];
      }
    }

    return [true, 200, null, "No recent migrations found to rollback."];
  }

  private function getClassNameFromMigrationFile($fileName): string
  {
    $fileName = preg_replace('/^\d+_/', '', $fileName);
    $fileName = ucwords(str_replace('_', ' ', $fileName));

    $className = str_replace(' ', '', $fileName);
    $className = DATABASE_MIGRATIONS_PATH_PREFIX . explode('.', $className)[0]; // to remove .php extension
    
    return $className;
  }
}