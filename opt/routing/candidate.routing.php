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
use TheLgbtWhip\Api\Controller\IssueController;



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

$app->group(
    '/view',
    function() use ($app, $request, $container) {
    
        /* @var $controller IssueController */
        $controller = $container->get('thelgbtwhip.api.controller.issue');
        
        $id = $request->get('candidateId');
        
        $callback = function($issueUriKey) use ($app, $controller, $id) {
            if ($id !== null) {
                return $controller->saveView($id, $issueUriKey);
            }
            
            $app->pass();
        };
        
        foreach (['put', 'post'] as $requestMethod) {
            $app->$requestMethod('/:issueUriKey', $callback);
        }
    }
);

$app->get('/:id', function($id) use ($controller) {
    return $controller->resolveByIdAction($id);
});
