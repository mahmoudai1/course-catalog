<?php

require_once 'utils/Response.php';
require_once 'utils/SanitizeParam.php';

use api\utils\Response;

class ApiHandler
{
  private $routes = [];
  private $headers;

  public function addRoute($method, $uri, $controller)
  {
      $this->routes[] = [
          'method' => $method,
          'uri' => APIS_V1_PREFIX . $uri,
          'controllerClass' => $controller['controller'],
          'controllerMethod' => $controller['method'],
      ];
  }

  public function handleRequest()
  {
    try
    {
      // $this->headers = getallheaders();
      // $authHeader = isset($this->headers['Authorization']) ? $this->headers['Authorization'] : null;
      
      $method = $_SERVER['REQUEST_METHOD'];
      $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

      foreach ($this->routes as $route) {
          if ($method === $route['method'] && $uri === $route['uri']) {
              $controller = new $route['controllerClass']();
              $action = $route['controllerMethod'];
              echo $controller->$action();

              return;
          }
      }

      echo Response::json(false, 404, null, "Request Not Found.");
    }
    catch (\Exception $exception)
    {
      echo Response::json(false, 500, null, 'Request Server Error.');
      error_log("Handle API Request Error: " . $exception->getMessage());
    }
  }
}
