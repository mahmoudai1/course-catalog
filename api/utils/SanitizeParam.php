<?php
namespace api\utils;

class SanitizeParam
{
  public static function clean(string $param, int $inputType) :string|null
  {
    return htmlspecialchars(filter_input($inputType, $param, FILTER_DEFAULT) ?? '', ENT_QUOTES, 'UTF-8') ?? null;
  }
}