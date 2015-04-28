<?php
/**
 * candidate.view.routing.php
 * 
 * Created 28-Apr-2015 09:31:30
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */

use Slim\Slim;
use TheLgbtWhip\Api\Controller\CandidateViewController;



/* @var $app Slim */
/* @var $controller CandidateViewController */
$controller = $container->get('thelgbtwhip.api.controller.candidate_view');

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
