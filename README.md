# Table of Contents
- [How to run](#how-to-run)
- [Overview](#overview)
- [Design](#design)
- [APIs](#apis)
- [Project Structure](#project-structure)
- [Demo Video](#demo)

## How to run
- After running Docker, cd to the project_folder and run `docker-compose up --build` (accessiblle through `http://cc.localhost/`).

## Overview
- As simple as it requires.
- No useless files/folders.
- No frontend/backend frameworks.
- Only pure PHP and JS written in a clean code with a clean and clear structure.

## Design
- Pure HTML and CSS.
- Simple, modern, and light design.
- Followed UI/UX best practices with different media queries.

## APIs
APIs requests and responses structure are validated, organized, handled, and managed dynamically.<br/><br/>
**The used APIs to get categories and courses are cached using JS Session Storage in order to minimize sql queries calls.**<br/><br/>
- `/getCategories`
- `/getCategoryById`
- `/getCategoriesTree` (To get categories in a way that can be easily hierarched in the side panel)
- `/updateCountsOfCourses` (To fill `count_of_courses` column and use less queries at fetching, can act as a trigger)
  
- `/getCourses`
- `/getCourseById`
- `/getCoursesByCategoryId` (To get the courses of children categories)
- `/updateMainCategoriesNames` (To fill `main_category_name` column and use less queries at fetching, can act as a trigger)

- `/migrate` (Migerate all DB migrations files that is not migrated yet)
- `/rollback` (Rollback DB migrated migrations within last minute)

## Project Structure
<img width="469" alt="Screenshot 2024-12-16 at 12 06 36 AM" src="https://github.com/user-attachments/assets/3bb17f64-9525-49aa-a416-b394b5ae7614" />


# Demo

https://github.com/user-attachments/assets/5ef45364-ef9e-4bcb-b52b-b8d150f3e204



