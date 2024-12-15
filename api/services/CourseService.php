<?php
namespace api\services;

use PDO;
use database\DB;

class CourseService
{
  private $db;

  public function __construct()
  {
    $this->db = DB::get();
  }

  public function getCourses(int $limit = 25, int $offset = 0): array
  {
    try
    {
      $query = $this->db->prepare("SELECT * FROM courses LIMIT :limit OFFSET :offset");
      $query->bindParam(':offset', $offset, PDO::PARAM_INT);
      $query->bindParam(':limit', $limit, PDO::PARAM_INT);
      $query->execute();

      $courses = $query->fetchAll(PDO::FETCH_ASSOC);

      return [true, 200, $courses ? $courses : [], null];
    }
    catch (\Exception $exception)
    {
      return [false, 500, null, $exception->getMessage()];
    }
  }

  public function getCourseById(String $id): array
  {
    try
    {
      $query = $this->db->prepare("SELECT * FROM courses WHERE id = :id");
      $query->bindParam(':id', $id, PDO::PARAM_STR_CHAR);
      $query->execute();

      $course = $query->fetch(PDO::FETCH_ASSOC);

      return [true, 200, $course ? $course : [], null];
    }
    catch (\Exception $exception)
    {
      return [false, 500, null, $exception->getMessage()];
    }
  }

  public function getCoursesByCategoryId(String $id, int $limit = 25, int $offset = 0): array
  {
    try
    {
      $query = $this->db->prepare("
      WITH RECURSIVE category_hierarchy AS (
            SELECT 
                id AS category_id,
                id AS sort_order,
                parent_id,
                name AS category_name,
                count_of_courses,
                1 AS level
            FROM categories
            WHERE id = :id

            UNION ALL

            SELECT 
                c.id AS category_id, 
                ch.sort_order,
                c.parent_id, 
                c.name AS category_name,
                c.count_of_courses,
                ch.level + 1 AS level
            FROM categories c
            INNER JOIN category_hierarchy ch ON c.parent_id = ch.category_id
        )
        SELECT 
            crs.name,
            crs.main_category_name,
            crs.description,
            crs.preview
        FROM category_hierarchy ch
        LEFT JOIN courses crs ON ch.category_id = crs.category_id
        WHERE crs.name IS NOT NULL
        ORDER BY ch.sort_order, ch.level");
      $query->bindParam(':id', $id, PDO::PARAM_STR_CHAR);
      $query->execute();

      $courses = $query->fetchAll(PDO::FETCH_ASSOC);

      return [true, 200, $courses ? $courses : [], null];
    }
    catch (\Exception $exception)
    {
      return [false, 500, null, $exception->getMessage()];
    }
  }

  public function updateMainCategoriesNames(): array
  {
    try
    {
      $query = "
            WITH RECURSIVE category_hierarchy AS (
                SELECT 
                    id AS category_id,
                    id AS sort_order,
                    parent_id,
                    name AS category_name,
                    name AS main_category_name,
                    1 AS level
                FROM categories
                WHERE parent_id IS NULL

                UNION ALL

                SELECT 
                    c.id AS category_id, 
                    ch.sort_order,
                    c.parent_id, 
                    c.name AS category_name, 
                    ch.main_category_name AS main_category_name,
                    ch.level + 1 AS level
                FROM categories c
                INNER JOIN category_hierarchy ch ON c.parent_id = ch.category_id
            )
            UPDATE courses
            JOIN category_hierarchy ch ON courses.category_id = ch.category_id
            SET courses.main_category_name = ch.main_category_name;
          ";
      $this->db->exec($query);
      return [true, 200, null, "Main Category Name for Courses updated successfully."];
    }
    catch (\Exception $exception)
    {
      return [false, 500, null, $exception->getMessage()];
    }
    
  }
}