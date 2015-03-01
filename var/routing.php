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
use Symfony\Component\DependencyInjection\ContainerBuilder;



if (!isset($container)) {
    die('Dependency injection container is unavailable.');
}

/* @var $container ContainerBuilder */
/* @var $app Slim */
$app = $container->get('thelgbtwhip.api.app');

$app->get(
    '/constituency/search',
    function() use ($app, $container) {
        return print $container->get('thelgbtwhip.api.controller.constituency')->resolveByPostcodeAction(
            $app->request->get('postcode')
        );
    }
);
