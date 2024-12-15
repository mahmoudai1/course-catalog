<?php

require_once 'config/app.php';
require_once 'ApiHandler.php';

require_once '../database/database.php';
require_once '../database/migration.php';

require_once 'controllers/CategoryController.php';
require_once 'controllers/CourseController.php';
require_once 'controllers/MigrationController.php';


$apiHandler = new ApiHandler();

$apiHandler->addRoute('GET', '/getCategories', ['controller' => APIS_CONTROLLERS_PATH_PREFIX . 'CategoryController', 'method' => 'getCategories']);
$apiHandler->addRoute('GET', '/getCategoryById', ['controller' => APIS_CONTROLLERS_PATH_PREFIX . 'CategoryController', 'method' => 'getCategoryById']);
$apiHandler->addRoute('GET', '/getCategoriesTree', ['controller' => APIS_CONTROLLERS_PATH_PREFIX . 'CategoryController', 'method' => 'getCategoriesTree']);
$apiHandler->addRoute('POST', '/updateCountsOfCourses', ['controller' => APIS_CONTROLLERS_PATH_PREFIX . 'CategoryController', 'method' => 'updateCountsOfCourses']);

$apiHandler->addRoute('GET', '/getCourses', ['controller' => APIS_CONTROLLERS_PATH_PREFIX . 'CourseController', 'method' => 'getCourses']);
$apiHandler->addRoute('GET', '/getCourseById', ['controller' => APIS_CONTROLLERS_PATH_PREFIX . 'CourseController', 'method' => 'getCourseById']);
$apiHandler->addRoute('GET', '/getCoursesByCategoryId', ['controller' => APIS_CONTROLLERS_PATH_PREFIX . 'CourseController', 'method' => 'getCoursesByCategoryId']);
$apiHandler->addRoute('POST', '/updateMainCategoriesNames', ['controller' => APIS_CONTROLLERS_PATH_PREFIX . 'CourseController', 'method' => 'updateMainCategoriesNames']);

$apiHandler->addRoute('POST', '/migrate', ['controller' => APIS_CONTROLLERS_PATH_PREFIX . 'MigrationController', 'method' => 'migrate']);
$apiHandler->addRoute('POST', '/rollback', ['controller' => APIS_CONTROLLERS_PATH_PREFIX . 'MigrationController', 'method' => 'rollback']);

$apiHandler->handleRequest();