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

// Handle constituency routes
$app->group('/constituency', function() use ($app, $container) {
    $app->get(
        '/search',
        function() use ($app, $container) {
            return $container->get('thelgbtwhip.api.controller.constituency')->resolveByPostcodeAction(
                $app->request->get('postcode')
            );
        }
    );
});

