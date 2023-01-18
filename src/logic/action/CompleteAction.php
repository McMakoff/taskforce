<?php

namespace taskforce\logic\action;

class CompleteAction extends AbstractAction
{
  public static function getLabel()
  {
    return 'Завершить';
  }

  public static function getInternalName()
  {
    return 'act_complete';
  }

  public static function checkRight(int $performerId, int $clientId, int $currentUserId)
  {
    return $performerId === $currentUserId;
  }
}