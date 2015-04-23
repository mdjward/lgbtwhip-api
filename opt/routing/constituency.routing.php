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
/* @var $app Slim */
/* @var $request Request */
$controller = $container->get('thelgbtwhip.api.controller.constituency');
$request = $app->request;



// Search
$app->get(
    '/search',
    function() use ($request, $controller) {
    
        return $controller->resolveByPostcodeAction(
            $request->get('postcode')
        );
        
    }
);

$app->get(
    '/',
    function() use ($app, $request, $controller) {
        
        if (($id = $request->get('id')) !== null) {
            return $controller->resolveByIdAction($id);
        }
        
        if (($name = $request->get('name')) !== null) {
            return $controller->resolveByNameAction($name);
        }
        
        $app->pass();
    }
);
