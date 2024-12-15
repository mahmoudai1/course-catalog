<?php

namespace database\migrations;

class CreateCoursesTable
{
  function up() {
    return "
      CREATE TABLE courses (
        id CHAR(36) NOT NULL,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        preview VARCHAR(255),
        category_id CHAR(36),
        main_category_name VARCHAR(255),
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP DEFAULT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
      )
    ";
  }

  function down() {
    return "
      DROP TABLE courses
    ";
  }
}