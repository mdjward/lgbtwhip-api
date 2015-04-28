<?php
/**
 * issue.routing.php
 * 
 * Created 20-Apr-2015 18:32:21
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */

use Slim\Http\Request;
use Slim\Slim;
use TheLgbtWhip\Api\Controller\IssueController;



/* @var $controller IssueController */
/* @var $app Slim */
/* @var $request Request */
$controller = $container->get('thelgbtwhip.api.controller.issue');
$request = $app->request;



$app->get('/', function() use ($controller) {
    return $controller->getAllIssuesAction();
});
