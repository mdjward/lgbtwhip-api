<?php
/**
 * cli-config.php
 * 
 * Created 09-Mar-2015 07:35:54
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */

use Doctrine\ORM\Tools\Console\ConsoleRunner;



// Establish the /var base path
$varPath = __DIR__ . '/var';

// Load the container by retrieving from cache and/or building
$container = require_once $varPath . '/bootstrap.php';

// Initialise and return the helper set for the console runner
return ConsoleRunner::createHelperSet(
    $container->get('thelgbtwhip.api.orm.entity_manager')
);
