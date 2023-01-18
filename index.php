<?php
require_once("vendor/autoload.php");

use taskforce\logic\action\CancelAction;
use taskforce\logic\AvailableActions;

$strategy = new AvailableActions(AvailableActions::STATUS_NEW, 1, 2);

//var_dump($strategy->getNextStatus(new CancelAction()) === AvailableActions::STATUS_WORKING);
var_dump($strategy->getAllowedActions($strategy::ROLE_PERFORMER, 2));
var_dump($strategy->getAllowedActions($strategy::ROLE_CLIENT, 2));
var_dump($strategy->getAllowedActions($strategy::ROLE_CLIENT, 1));