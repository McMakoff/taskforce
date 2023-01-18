<?php

namespace taskforce\logic\action;

class CancelAction extends AbstractAction
{
  public static function getLabel()
  {
    return 'Отменить';
  }

  public static function getInternalName()
  {
    return 'act_cancel';
  }

  public static function checkRight(int $performerId, int $clientId, int $currentUserId)
  {
    return $performerId === $currentUserId;
  }
}