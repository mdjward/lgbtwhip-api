<?php
/**
 * error.routing.php
 * 
 * Created 21-Apr-2015 08:21:13
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */

use Slim\Slim;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TheLgbtWhip\Api\Controller\ErrorController;



/* @var $app Slim */
/* @var $container ContainerInterface */
/* @var $controller ErrorController */
$controller = $container->get('thelgbtwhip.api.controller.error');



$app->notFound(function() use ($controller) {
    return $controller->error404Action();
});

$app->error(function(Exception $ex) use ($controller) {
    return $controller->exceptionAction(
        new Exception(
            $ex->getMessage(),
            500,
            $ex
        )
    );
});

$app->any('/error/:errorCode', function($errorCode) use ($app, $controller) {
    
    switch ((int) $errorCode) {
        case 401:
            return $controller->error401Action();
        case 403:
            return $controller->error403Action();
        case 404:
            return $controller->error404Action();
    }
    
    return $controller->errorAction($errorCode, '');
    
})->conditions(array('errorCode' => '^401|403|404|500$'));