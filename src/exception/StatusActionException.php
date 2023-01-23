<?php

namespace taskforce\exception;

class StatusActionException extends \Exception
{
  public function __construct($message)
  {
    parent::__construct($message);
  }
}