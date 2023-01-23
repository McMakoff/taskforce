<?php

namespace taskforce\logic;

use taskforce\exception\StatusActionException;
use taskforce\logic\action\AbstractAction;
use taskforce\logic\action\CancelAction;
use taskforce\logic\action\CompleteAction;
use taskforce\logic\action\DenyAction;
use taskforce\logic\action\ResponseAction;

class AvailableActions
{
  const STATUS_NEW = 'new';
  const STATUS_WORKING = 'working';
  const STATUS_CANCEL = 'cancel';
  const STATUS_PERFORMED = 'performed';
  const STATUS_FAILED = 'failed';

  const ROLE_PERFORMER = 'performer';
  const ROLE_CLIENT = 'client';

  public string $status;
  public int $performerID;
  public ?int $clientID;

  public function __construct(string $status, int $performerID, ?int $clientID = null)
  {
    $this->setStatus($status);
    $this->performerID = $performerID;
    $this->clientID = $clientID;
  }

  public function getNextStatus (AbstractAction $action): ?string
  {
    $map = [
      ResponseAction::class  => self::STATUS_WORKING,
      CancelAction::class => self::STATUS_CANCEL,
      CompleteAction::class => self::STATUS_PERFORMED,
      DenyAction::class => self::STATUS_NEW,
    ];

    return $map[get_class($action)] ?? null;
  }

  public function getAllowedActions (string $role, int $currentUserId): array
  {
    $statusActions = $this->getAllowedStatusActions($this->status);
    $roleActions = $this->getRoleStatusActions($role);

    $allowActions = array_intersect($statusActions, $roleActions);

    $allowActions = array_filter($allowActions, function ($action) use ($currentUserId) {
      return $action::checkRight($this->performerID, $this->clientID, $currentUserId);
    });

    return array_values($allowActions);
  }

  public static function getAllowedStatusActions (string $status): array
  {
    $map = [
      self::STATUS_NEW => [CancelAction::class, ResponseAction::class],
      self::STATUS_WORKING => [DenyAction::class, CompleteAction::class],
      self::STATUS_CANCEL => [],
      self::STATUS_PERFORMED => [],
      self::STATUS_FAILED => [],
    ];

    return $map[$status];
  }

  public static function getRoleStatusActions (string $role): array
  {
    $map = [
      self::ROLE_CLIENT => [CancelAction::class, CompleteAction::class],
      self::ROLE_PERFORMER => [DenyAction::class, ResponseAction::class],
    ];

    return $map[$role];
  }

  private function getStatusesMap (string $status): ?string
  {
    $map = [
      self::STATUS_NEW => 'Новое',
      self::STATUS_WORKING => 'В работе',
      self::STATUS_CANCEL => 'Отменено',
      self::STATUS_PERFORMED => 'Выполненно',
      self::STATUS_FAILED => 'Провалено',
    ];

    return $map[$status] ?? null;
  }

  private function setStatus (string $status): void {
    $allowedStatus = [
      self::STATUS_NEW,
      self::STATUS_WORKING,
      self::STATUS_CANCEL,
      self::STATUS_PERFORMED,
      self::STATUS_FAILED,
    ];

    if (!in_array($status, $allowedStatus)) {
      throw new StatusActionException('Ошибочка вышла');
    }

    if (in_array($status, $allowedStatus)) {
      $this->status = $status;
    }
  }
}