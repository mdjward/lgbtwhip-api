<?php
/**
 * constituency.routing.php
 * 
 * Created 20-Apr-2015 18:32:38
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */

use Slim\Http\Request;
use Slim\Slim;
use TheLgbtWhip\Api\Controller\ConstituencyController;



/* @var $controller ConstituencyController */
$controller = $container->get('thelgbtwhip.api.controller.constituency');



$app->get(
    '/',
    function() use ($controller) {
        return $controller->getAll();
    }
);
