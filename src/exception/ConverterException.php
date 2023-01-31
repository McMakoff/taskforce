<?php

namespace taskforce\exception;

class ConverterException extends \Exception
{
  public function __construct($message)
  {
    parent::__construct($message);
  }
}