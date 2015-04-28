<?php
/**
 * candidate.routing.php
 * 
 * Created 20-Apr-2015 18:32:28
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */

use Slim\Http\Request;
use Slim\Slim;
use TheLgbtWhip\Api\Controller\CandidateController;



/* @var $controller CandidateController */
/* @var $app Slim */
/* @var $request Request */
$controller = $container->get('thelgbtwhip.api.controller.candidate');
$request = $app->request;



$app->get(
    '/',
    function() use ($app, $request, $controller) {
    
        if (($id = $request->get('id', $request->get('candidateId'))) !== null) {
            return $controller->resolveByIdAction($id);
        }
        
        if (($name = $request->get('name')) !== null) {
            return $controller->resolveByNameAction($name);
        }
        
        $app->pass();
    }
);

$app->group('/view', function() use ($app, $request, $container) {
    require_once __DIR__ . '/candidate.view.routing.php';
});

foreach (['image', 'photo'] as $routePrefix) {
    $app->group('/' . $routePrefix, function() use ($app, $request, $container) {
        require_once __DIR__ . '/candidate.image.routing.php';
    });
}

$app->get('/:id', function($id) use ($controller) {
    return $controller->resolveByIdAction($id);
})->conditions(['id' => '\d+']);
