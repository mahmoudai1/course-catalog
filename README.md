# Table of Contents
- [Overview](#overview)
- [Design](#design)
- [APIs](#apis)
- [Project Structure](#project-structure)
- [Demo](#demo)

  
## Overview
- As simple as it is.
- No useless files/folders.
- No frontend/backend frameworks.
- Only pure PHP and JS written in a clean code with a clean and clear structure.

## Design
- Pure HTML and CSS.
- Simple, modern, and light design.
- Followed UI/UX best practices with multiple media queries.

## APIs
APIs requests and responses are handled and managed dynamically.<br/>
- `/getCategories`
- `/getCategoryById`
- `/getCategoriesTree` (To get categories in a way that can be easily hierarched in the side panel)
- `/updateCountsOfCourses` (To fill `count_of_courses` column and use less queries at fetching)
  
- `/getCourses`
- `/getCourseById`
- `/getCoursesByCategoryId` (To get the courses of children categories)
- `/updateMainCategoriesNames` (To fill `main_category_name` column and use less queries at fetching)

- `/migrate` (Migerate all migrations files that is not migrated yet)
- `/rollback` (Rollback all migrated migrations within last minute)

## Project Structure
<img width="469" alt="Screenshot 2024-12-16 at 12 06 36 AM" src="https://github.com/user-attachments/assets/3bb17f64-9525-49aa-a416-b394b5ae7614" />


# Demo

https://github.com/user-attachments/assets/5ef45364-ef9e-4bcb-b52b-b8d150f3e204



