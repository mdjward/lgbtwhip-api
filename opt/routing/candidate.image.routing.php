<?php
/**
 * candidate.image.routing.php
 * 
 * Created 28-Apr-2015 09:31:38
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */

use Slim\Http\Request;
use Slim\Slim;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TheLgbtWhip\Api\Controller\CandidateImageController;



/* @var $container ContainerInterface */
/* @var $controller CandidateImageController */
/* @var $app Slim */
/* @var $request Request */
$controller = $container->get('thelgbtwhip.api.controller.candidate_image');

$candidateIdConditions = ['candidateId' => '\d+'];



// Get candidate using URI route
$app->get('/:candidateId', function($candidateId) use ($controller) {

    return $controller->getCandidateImageAction($candidateId);
    
})->conditions($candidateIdConditions);

// Get candidate using query string parameter
$app->get('', function() use ($app, $request, $controller) {

    if (($candidateId = $request->get('candidateId')) !== null) {
        return $controller->getCandidateImageAction($candidateId);
    }

    $app->pass();
});

// Put candidate image in place
$app->put('/:candidateId', function($candidateId) use ($controller) {
    
    return $controller->putCandidateImageAction($candidateId);
    
})->conditions($candidateIdConditions);
