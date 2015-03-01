<?php
/**
 * app.php
 * 
 * Created 03-Feb-2015 20:09:03
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */

$varPath = __DIR__ . '/../var';

require_once $varPath . '/bootstrap.php';
require_once $varPath . '/routing.php';

/* @var $app \Slim\Slim */
$app->run();
