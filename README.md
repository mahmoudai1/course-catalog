# course-catalog

## Overview
- As simple as it is.
- No useless files/folders.
- No frontend/backend frameworks.
- Only pure PHP and JS written in a clean code with a clean and clear structure.

## Design
- Simple, modern, and light weighted design.
- Followed UI/UX best practices with multiple media queries.

## APIs `/v1`
APIs requests and responses are handled and managed dynamically.
- `/getCategories`
- `/getCategoryById`
- `/getCategoriesTree` (To get categories in a way that can be easily hierarchiced in the side panel)
- `/updateCountsOfCourses` (To use fill `count_of_courses` column and use less queries at fetching)
  
- `/getCourses`
- `/getCourseById`
- `/getCoursesByCategoryId` (To get the courses of children categories)
- `/updateMainCategoriesNames` (To use fill `main_category_name` column and use less queries at fetching)

- `/migrate` (Migerate all migrations files that is not migrated yet)
- `/rollback` (Rollback all migrated migrations within last minute)

  
