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
    
    /**
     * 
     * @param Constituency $constituency
     * @param ResponseInterface $response
     */
    public function processCandidates(
        Constituency $constituency,
        ResponseInterface $response
    );
    
    /**
     * 
     * @param ResponseInterface $response
     * @return Candidate
     */
    public function processCandidateSearchResults(ResponseInterface $response);
    
    /**
     * 
     * @param ResponseInterface $response
     * @return Constituency
     */
    public function processConstituencySearchResults(ResponseInterface $response);
    
}
