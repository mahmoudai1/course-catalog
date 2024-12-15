<?php

namespace database\migrations;

class CreateCategoriesTable
{
  function up() {
    return "
      CREATE TABLE categories (
        id CHAR(36) NOT NULL,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        parent_id CHAR(36),
        count_of_courses INT NOT NULL DEFAULT 0,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP DEFAULT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
      )
    ";
  }
  
  function down() {
    return "
      ALTER TABLE courses DROP FOREIGN KEY courses_ibfk_1;
      DROP TABLE categories;
    ";
  }
}
