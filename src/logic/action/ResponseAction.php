<?php


namespace taskforce\logic\action;


class ResponseAction extends AbstractAction
{
    public static function getLabel(): string
    {
        return "Откликнуться";
    }

    public static function getInternalName(): string
    {
        return 'act_response';
    }

    public static function checkRight(?int $performerId, ?int $clientId, int $currentUserId): bool
    {
        return $currentUserId !== $performerId;
    }
}
