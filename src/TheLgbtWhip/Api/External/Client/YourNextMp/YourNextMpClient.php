<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace TheLgbtWhip\Api\External\Client\YourNextMp;

use GuzzleHttp\Client;
use TheLgbtWhip\Api\External\Client\AbstractRestServiceClient;
use TheLgbtWhip\Api\Model\Constituency;



/**
 * Description of YourNextMpClient
 *
 * @author matt
 */
class YourNextMpClient extends AbstractRestServiceClient implements YourNextMpClientInterface
{
    
    /**
     *
     * @var YourNextMpProcessorInterface 
     */
    protected $processor;
    
    
    
    /**
     * 
     * @param Client $httpClient
     * @param YourNextMpProcessorInterface $processor
     */
    public function __construct(
        Client $httpClient,
        YourNextMpProcessorInterface $processor
    ) {
        parent::__construct($httpClient);
        
        $this->processor = $processor;
    }
    
    /**
     * 
     * @param Constituency $constituency
     * @return array
     */
    public function getCandidatesForConstituency(Constituency $constituency)
    {
        return $this->processor->processCandidates(
            $constituency,
            $this->httpClient->get(
                sprintf(
                    'posts/%s?embed=membership.person',
                    $constituency->getId()
                )
            )
        );
    }
    
}
