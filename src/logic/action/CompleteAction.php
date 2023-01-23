<?php

namespace taskforce\logic\action;

class CompleteAction extends AbstractAction
{
  public static function getLabel(): string
  {
    return 'Завершить';
  }

  public static function getInternalName(): string
  {
    return 'act_complete';
  }

  public static function checkRight(?int $performerId, ?int $clientId, int $currentUserId): bool
  {
    return $performerId === $currentUserId;
  }
}