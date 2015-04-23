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
use Slim\Http\Response;
use TheLgbtWhip\Api\Controller\ConstituencyController;



/* @var $controller ConstituencyController */
/* @var $request Request */
/* @var $response Response */
$controller = $container->get('thelgbtwhip.api.controller.constituency');
$request = $app->request;
$response = $app->response;



// Search
$app->get(
    '/search',
    function() use ($request, $response, $controller) {
    
        throw new Exception('Random', 101);
    
        $response->setStatus(401);
    
        return $controller->resolveByPostcodeAction(
            $request->get('postcode')
        );
    }
);

