<?php
  namespace api\utils;

  class Response
  {
    public static function json(bool $status, int $code = 200, ?array $data = null, ?string $message = null) :bool|string
    {
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Headers: Content-Type");
      header('Content-Type: application/json');
      http_response_code($code);
      return json_encode([
        'status' => $status,
        'code' => $code,
        'data' => $data,
        'message' => $message
      ], JSON_PRETTY_PRINT);
    }
  }