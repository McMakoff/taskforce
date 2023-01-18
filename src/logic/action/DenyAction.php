<?php


namespace taskforce\logic\action;


class DenyAction extends AbstractAction
{
    public static function getLabel()
    {
        return "Отказаться";
    }

    public static function getInternalName()
    {
        return "act_deny";
    }

    public static function checkRight(int $performerId, int $clientId, int $currentUserId)
    {
        return $currentUserId === $performerId;
    }

}
