<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TheLgbtWhip\Api\External\Client\MapIt;

use GuzzleHttp\Message\Response;
use TheLgbtWhip\Api\External\Client\YourNextMp\YourNextMpClientInterface;
use TheLgbtWhip\Api\Model\Constituency;

/**
 * Description of MapItProcessor
 *
 * @author matt
 */
class MapItProcessor implements MapItProcessorInterface
{
    
    /**
     *
     * @var YourNextMpClientInterface
     */
    protected $yourNextMpClient;
    
    
    
    /**
     * 
     * @param YourNextMpClientInterface $yourNextMpClient
     */
    public function __construct(YourNextMpClientInterface $yourNextMpClient)
    {
        $this->yourNextMpClient = $yourNextMpClient;
    }
    
    /**
     * 
     * @param Response $response
     * @return Constituency
     */
    public function processConstituencyData(Response $response)
    {
        $constituency = $this->buildConstituencyFromResponse($response);
        
        foreach ($this->yourNextMpClient->getCandidatesForConstituency($constituency) as $candidate) {
            $constituency->addCandidate($candidate);
        }
        
        return $constituency;
    }
    
    /**
     * 
     * @param Response $response
     * @return Constituency
     * @throws PostcodeResolutionException
     * @throws PostcodeInvalidResponseException
     */
    protected function buildConstituencyFromResponse(Response $response)
    {
        $constituencyData = $response->json();
        
        if (isset($constituencyData['error'])) {
            throw new PostcodeResolutionException(
                $response,
                $constituencyData['error']
            );
        }
        
        if (!isset($constituencyData['shortcuts']['WMC'])) {
            throw new PostcodeResolutionException(
                $response,
                'Parliamentary constituency could not be found for postcode'
            );
        }
        
        $constituencyKey = $constituencyData['shortcuts']['WMC'];
        
        if (!isset($constituencyData['areas'][$constituencyKey])) {
            throw new PostcodeInvalidResponseException(
                $response,
                'Parliamentary constituency information is unavailable for postcode'
            );
        }
        
        $constituencyArea = $constituencyData['areas'][$constituencyKey];
        
        if (!isset($constituencyArea['id']) || !isset($constituencyArea['name'])) {
            throw new PostcodeInvalidResponseException(
                $response,
                'Parliamentary constituency information is missing ID or name'
            );
        }
        
        return
            (new Constituency())
                ->setName($constituencyArea['name'])
                ->setId($constituencyArea['id'])
        ;
    }
    
}
