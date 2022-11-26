<?php

namespace taskforce\logic;

class AvailableActions
{
  const STATUS_NEW = 'new';
  const STATUS_WORKING = 'working';
  const STATUS_CANCEL = 'cancel';
  const STATUS_PERFORMED = 'performed';
  const STATUS_FAILED = 'failed';

  const ACTION_RESPONSE = 'response';
  const ACTION_CANCEL = 'cancel';
  const ACTION_PERFORMED = 'performed';
  const ACTION_DENY = 'deny';

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

  public function getNextStatus (string $action): ?string
  {
    $map = [
      self::ACTION_RESPONSE => self::STATUS_WORKING,
      self::ACTION_CANCEL => self::STATUS_CANCEL,
      self::ACTION_PERFORMED => self::STATUS_PERFORMED,
      self::ACTION_DENY => self::STATUS_NEW,
    ];

    return $map[$action] ?? null;
  }

  private function getAllowedActions (string $status): array
  {
    $map = [
      self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_RESPONSE],
      self::STATUS_WORKING => [self::ACTION_PERFORMED, self::ACTION_DENY, self::ACTION_CANCEL],
    ];

    return $map[$status] ?? [];
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

  private function getActionsMap (string $action): ?string
  {
    $map = [
      self::ACTION_RESPONSE => 'Откликнуться',
      self::ACTION_CANCEL => 'Отменить',
      self::ACTION_PERFORMED => 'Выполнено',
      self::ACTION_DENY => 'Отказаться',
    ];

    return $map[$action] ?? null;
  }

  private function setStatus (string $status): void {
    $allowedStatus = [
      self::STATUS_NEW,
      self::STATUS_WORKING,
      self::STATUS_CANCEL,
      self::STATUS_PERFORMED,
      self::STATUS_FAILED,
    ];

    $this->status = $allowedStatus[$status] ?? '';
  }
}