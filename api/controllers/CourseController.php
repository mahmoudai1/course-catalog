<?php
namespace api\controllers;

require_once 'services/CourseService.php';

use api\utils\Response;
use api\utils\SanitizeParam;
use api\services\CourseService;

class CourseController
{
  public function getCourses() :bool|string
  {
    $limit = intval(SanitizeParam::clean('limit', INPUT_GET));
    $limit = $limit ? $limit : 25;
    $offset = intval(SanitizeParam::clean('offset', INPUT_GET));

    $courseService = new CourseService();
    [$status, $code, $data, $message] = $courseService->getCourses($limit, $offset);

    return Response::json($status, $code, $data, $message);
  }

  public function getCourseById() :bool|string
  {
    $id = SanitizeParam::clean('id', INPUT_GET);
    if(!$id)
    {
      return Response::json(false, 500, null, 'Course ID is required.');
    }

    $courseService = new CourseService();
    [$status, $code, $data, $message] = $courseService->getCourseById($id);

    return Response::json($status, $code, $data, $message);
  }

  public function getCoursesByCategoryId(): bool|string
  {
    $id = SanitizeParam::clean('id', INPUT_GET);

    $limit = intval(SanitizeParam::clean('limit', INPUT_GET));
    $limit = $limit ? $limit : 25;
    $offset = intval(SanitizeParam::clean('offset', INPUT_GET));

    if(!$id)
    {
      return Response::json(false, 500, null, 'Category ID is required.');
    }

    $courseService = new CourseService();
    [$status, $code, $data, $message] = $courseService->getCoursesByCategoryId($id, $limit, $offset);

    return Response::json($status, $code, $data, $message);
  }

  public function updateMainCategoriesNames(): bool|string
  {
    $courseService = new CourseService();
    [$status, $code, $data, $message] = $courseService->updateMainCategoriesNames();

    return Response::json($status, $code, $data, $message);
  }
}