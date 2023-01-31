<?php
require_once("vendor/autoload.php");

use taskforce\exception\StatusActionException;
use taskforce\helper\CsvSqlConverter;
use taskforce\logic\action\CancelAction;
use taskforce\logic\AvailableActions;

try {
  $strategy = new AvailableActions(AvailableActions::STATUS_NEW, 3, 1);
} catch (StatusActionException $e) {
  die($e->getMessage());
}

/*var_dump($strategy->getNextStatus(new CancelAction()));
var_dump($strategy->getAllowedActions($strategy::ROLE_PERFORMER, 2));
var_dump($strategy->getAllowedActions($strategy::ROLE_CLIENT, 2));
var_dump($strategy->getAllowedActions($strategy::ROLE_CLIENT, 1));*/

$f = new CsvSqlConverter(__DIR__ . '/data/csv');
$f->convertFiles(__DIR__ . '/data/sql');