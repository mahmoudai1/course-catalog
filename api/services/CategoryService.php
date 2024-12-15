<?php
namespace api\services;

use PDO;
use database\DB;

class CategoryService
{
  private $db;

  public function __construct()
  {
    $this->db = DB::get();

    //* Just for documentation, it is not used. 
    //* It is an optimized procedure implementation instead of how the current updateCountsOfCourses() goes.
    //* In order to reduce the DB calls.
    $storeProcedureQuery = "DELIMITER $$
        CREATE PROCEDURE UpdateCountsOfCourses()
        BEGIN
            DECLARE current_id CHAR(36);

            DECLARE id_cursor CURSOR FOR
                SELECT id FROM categories;

            DECLARE done INT DEFAULT 0;

            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

            OPEN id_cursor;

            read_loop: LOOP
                FETCH id_cursor INTO current_id;
                IF done THEN
                    LEAVE read_loop;
                END IF;

                WITH RECURSIVE category_hierarchy_cte AS (
                    SELECT 
                        id, 
                        name, 
                        parent_id
                    FROM categories
                    WHERE id = current_id

                    UNION ALL

                    SELECT 
                        c.id, 
                        c.name, 
                        c.parent_id
                    FROM categories c
                    INNER JOIN category_hierarchy_cte ch on c.parent_id = ch.id
                ),

                courses_count_cte AS (
                    SELECT SUM(courses_count) AS sum_courses_count FROM
                    (
                        SELECT ch.id, ch.name, COUNT(courses.id) courses_count 
                        FROM category_hierarchy_cte ch
                        INNER JOIN courses ON courses.category_id = ch.id
                        GROUP BY ch.id, ch.name
                    ) AS sub_query
                )

                UPDATE categories 
                SET count_of_courses = COALESCE((SELECT sum_courses_count FROM courses_count_cte), 0)
                WHERE id = current_id;
                
            END LOOP;

            CLOSE id_cursor;
        END //

        DELIMITER ;
        ";
  }

  public function getCategories(int $limit = 25, int $offset = 0): array
  {
    try
    {
      $query = $this->db->prepare("SELECT * FROM categories LIMIT :limit OFFSET :offset");
      $query->bindParam(':offset', $offset, PDO::PARAM_INT);
      $query->bindParam(':limit', $limit, PDO::PARAM_INT);
      $query->execute();

      $categories = $query->fetchAll(PDO::FETCH_ASSOC);

      return [true, 200, $categories ? $categories : [], null];
    }
    catch (\Exception $exception)
    {
      return [false, 500, null, $exception->getMessage()];
    }
  }

  public function getCategoryById(String $id): array
  {
    try
    {
      $query = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
      $query->bindParam(':id', $id, PDO::PARAM_STR_CHAR);
      $query->execute();

      $category = $query->fetch(PDO::FETCH_ASSOC);

      return [true, 200, $category ? $category : [], null];
    }
    catch (\Exception $exception)
    {
      return [false, 500, null, $exception->getMessage()];
    }
  }

  public function getCategoriesTree(int $limit = 25, int $offset = 0): array
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
            WHERE parent_id IS NULL

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
        SELECT DISTINCT
            ch.category_id, 
            ch.parent_id, 
            ch.category_name,
            ch.count_of_courses,
            ch.sort_order,
            ch.level
        FROM category_hierarchy ch
        LEFT JOIN courses crs ON ch.category_id = crs.category_id
        ORDER BY ch.sort_order, ch.level
        LIMIT :limit
        OFFSET :offset;
      ");
      $query->bindParam(':offset', $offset, PDO::PARAM_INT);
      $query->bindParam(':limit', $limit, PDO::PARAM_INT);
      $query->execute();

      $categoriesWithCourses = $query->fetchAll(PDO::FETCH_ASSOC);

      return [true, 200, $categoriesWithCourses ? $categoriesWithCourses : [], null];
    }
    catch (\Exception $exception)
    {
      return [false, 500, null, $exception->getMessage()];
    }
  }

  public function updateCountsOfCourses(): array
  {
    try
    {
      $categoriesIds = $this->db->query("SELECT id FROM categories ORDER BY id")->fetchAll(PDO::FETCH_COLUMN);

      foreach($categoriesIds as $categoryId)
      {
        $stmt = $this->db->prepare("
          WITH RECURSIVE category_hierarchy_cte AS (
            SELECT 
                id, 
                name, 
                parent_id
            FROM categories
            WHERE id = ?

            UNION ALL

            SELECT 
                c.id, 
                c.name, 
                c.parent_id
            FROM categories c
            INNER JOIN category_hierarchy_cte ch on c.parent_id = ch.id
        ),

        courses_count_cte AS (
            SELECT SUM(courses_count) AS sum_courses_count FROM
            (
                SELECT ch.id, ch.name, COUNT(courses.id) courses_count 
                FROM category_hierarchy_cte ch
                INNER JOIN courses ON courses.category_id = ch.id
                GROUP BY ch.id, ch.name
            ) AS sub_query
        )

        UPDATE categories 
        SET count_of_courses = COALESCE((SELECT sum_courses_count FROM courses_count_cte), 0)
        WHERE id = ?;
        ");
        $stmt->execute([$categoryId, $categoryId]);
      }
      
      return [true, 200, null, "Count of courses updated successfully."];
    }
    catch (\Exception $exception)
    {
      return [false, 500, null, $exception->getMessage()];
    }
    
  }
}