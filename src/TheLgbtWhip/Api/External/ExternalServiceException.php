<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TheLgbtWhip\Api\External;

use Exception;
use GuzzleHttp\Message\Response;



/**
 * Description of ExternalServiceException
 *
 * @author matt
 */
abstract class ExternalServiceException extends Exception
{
    
    /**
     *
     * @var Response
     */
    private $response;
    
    
    
    /**
     * 
     * @param Response $response
     * @param string $message
     * @param Exception $previous
     */
    public function __construct(
        Response $response,
        $message,
        Exception $previous = null
    ) {
        parent::__construct($message, 0, $previous);
        
        $this->response = $response;
    }
    
    /**
     * 
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

}
