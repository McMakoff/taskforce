<?php

namespace taskforce\logic\action;

class CancelAction extends AbstractAction
{
  public static function getLabel(): string
  {
    return 'Отменить';
  }

  public static function getInternalName(): string
  {
    return 'act_cancel';
  }

  public static function checkRight(?int $performerId, ?int $clientId, int $currentUserId): bool
  {
    return $performerId === $currentUserId;
  }
}