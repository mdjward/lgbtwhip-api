<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TheLgbtWhip\Api\External\Client\MapIt;

use GuzzleHttp\Message\Response;
use GuzzleHttp\Message\ResponseInterface;
use TheLgbtWhip\Api\Model\Constituency;

/**
 * Description of MapItProcessorInterface
 *
 * @author matt
 */
interface MapItProcessorInterface
{
    
    /**
     * 
     * @param Response $response
     * @return Constituency
     */
    public function processConstituencyData(ResponseInterface $response);
    
}
