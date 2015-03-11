<?php
/**
 * cli-config.php
 * 
 * Created 09-Mar-2015 07:35:54
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */



// Establish the /var base path
$varPath = __DIR__ . '/var';

// Load the container by retrieving from cache and/or building
$container = require_once $varPath . '/bootstrap.php';

// Add migration commands to the Doctrine command set
if (isset($commands)) {
    $commands = array_merge(
        $commands,
        $container->get('thelgbtwhip.api.migrations.commands')->toArray()
    );
}

return $container->get('thelgbtwhip.api.migrations.helper_set');
