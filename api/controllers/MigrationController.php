<?php
namespace api\controllers;

use api\utils\Response;
use database\Migration;

class MigrationController
{
  public function migrate() :bool|string
  {
    $migration = new Migration();
    [$status, $code, $data, $message] = $migration->migrate();
    return Response::json($status, $code, $data, $message);
  }

  public function rollback() :bool|string
  {
    $migration = new Migration();
    [$status, $code, $data, $message] = $migration->rollback();
    return Response::json($status, $code, $data, $message);
  }
}