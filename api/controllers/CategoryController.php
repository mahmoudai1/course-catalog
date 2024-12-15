<?php
namespace api\controllers;

require_once 'services/CategoryService.php';

use api\utils\Response;
use api\utils\SanitizeParam;
use api\services\CategoryService;

class CategoryController
{
  public function getCategories() :bool|string
  {
    $limit = intval(SanitizeParam::clean('limit', INPUT_GET));
    $limit = $limit ? $limit : 25;
    $offset = intval(SanitizeParam::clean('offset', INPUT_GET));

    $categoryService = new CategoryService();
    [$status, $code, $data, $message] = $categoryService->getCategories($limit, $offset);

    return Response::json($status, $code, $data, $message);
  }

  public function getCategoryById() :bool|string
  {
    $id = SanitizeParam::clean('id', INPUT_GET);
    if(!$id)
    {
      return Response::json(false, 500, null, 'Category ID is required.');
    }

    $categoryService = new CategoryService();
    [$status, $code, $data, $message] = $categoryService->getCategoryById($id);

    return Response::json($status, $code, $data, $message);
  }

  public function getCategoriesTree(): bool|string
  {
    $limit = intval(SanitizeParam::clean('limit', INPUT_GET));
    $limit = $limit ? $limit : 25;
    $offset = intval(SanitizeParam::clean('offset', INPUT_GET));

    $categoryService = new CategoryService();
    [$status, $code, $data, $message] = $categoryService->getCategoriesTree($limit, $offset);

    return Response::json($status, $code, $data, $message);
  }

  public function updateCountsOfCourses(): bool|string
  {
    $categoryService = new CategoryService();
    [$status, $code, $data, $message] = $categoryService->updateCountsOfCourses();

    return Response::json($status, $code, $data, $message);
  }
}