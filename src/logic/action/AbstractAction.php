<?php

namespace taskforce\logic\action;

abstract class AbstractAction
{
  abstract public static function getLabel();
  abstract public static function getInternalName();
  abstract public static function checkRight(int $performerId, int $clientId, int $currentUserId);
}