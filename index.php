<?php
require_once("vendor/autoload.php");
ini_set('assert.exception', 1);

use taskforce\logic\AvailableActions;

$strategy = new AvailableActions(AvailableActions::STATUS_NEW, 1, 1);

var_dump($strategy->getNextStatus(AvailableActions::ACTION_RESPONSE) === AvailableActions::STATUS_WORKING);