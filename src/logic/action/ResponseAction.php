<?php


namespace taskforce\logic\action;


class ResponseAction extends AbstractAction
{
    public static function getLabel()
    {
        return "Откликнуться";
    }

    public static function getInternalName()
    {
        return 'act_response';
    }

    public static function checkRight(int $performerId, int $clientId, int $currentUserId)
    {
        return $currentUserId !== $performerId;
    }
}
