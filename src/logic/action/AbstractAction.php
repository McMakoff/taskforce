<?php

namespace taskforce\logic\action;

abstract class AbstractAction
{
  abstract public static function getLabel(): string;
  abstract public static function getInternalName(): string;
  abstract public static function checkRight(?int $performerId, ?int $clientId, int $currentUserId): bool;
}