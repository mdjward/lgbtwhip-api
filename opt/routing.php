<?php
/**
 * routing.php
 * 
 * Created 01-Mar-2015 13:59:04
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */

use Slim\Slim;
use Symfony\Component\DependencyInjection\ContainerInterface;



// This script is not intended to run directly; if the container isn't set, then terminate
if (!isset($container) || !($container instanceof ContainerInterface)) {
    die('Dependency injection container is unavailable.');
}



/* @var $container ContainerInterface */
/* @var $app Slim */
$app = $container->get('thelgbtwhip.api.app');



// Handle errors
require_once __DIR__ . '/routing/error.routing.php';



// Handle constituency routes
$app->group('/constituency', function() use ($app, $container) {
    require_once __DIR__ . '/routing/constituency.routing.php';
});

// Handle candidate routes
$app->group('/candidate', function() use ($app, $container) {
    require_once __DIR__ . '/routing/candidate.routing.php';
});

// Handle issue routes
$app->group('/issue', function() use ($app, $container) {
    require_once __DIR__ . '/routing/issue.routing.php';
});



// Return the Slim application to the calling script
return $app;
