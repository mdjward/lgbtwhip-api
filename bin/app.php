<?php
/**
 * app.php
 * 
 * Created 03-Feb-2015 20:09:03
 *
 * @author M.D.Ward <dev@mattdw.co.uk>
 */

use Slim\Slim;



// Establish the /var base path
$varPath = __DIR__ . '/../var';

// Load the container by retrieving from cache and/or building
$container = require_once $varPath . '/bootstrap.php';

// Load the application by applying routing configuration
$app = require_once $varPath . '/routing.php';

// Execute
/* @var $app Slim */
$app->run();
