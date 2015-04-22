<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TheLgbtWhip\Api\External\Client\YourNextMp;

use GuzzleHttp\Message\ResponseInterface;
use TheLgbtWhip\Api\Model\Constituency;

/**
 *
 * @author matt
 */
interface YourNextMpProcessorInterface
{
    
    public function processCandidates(
        Constituency $constituency,
        ResponseInterface $response
    );
    
}
