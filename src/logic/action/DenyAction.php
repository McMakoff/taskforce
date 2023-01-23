<?php


namespace taskforce\logic\action;


class DenyAction extends AbstractAction
{
    public static function getLabel(): string
    {
        return "Отказаться";
    }

    public static function getInternalName(): string
    {
        return "act_deny";
    }

    public static function checkRight(?int $performerId, ?int $clientId, int $currentUserId): bool
    {
        return $currentUserId === $performerId;
    }

}
