<?php

namespace TheLgbtWhip\Api\External\Client\MapIt;

use GuzzleHttp\Client;
use TheLgbtWhip\Api\External\Client\AbstractRestServiceClient;
use TheLgbtWhip\Api\External\PostcodeToConstituencyMappingInterface;
use TheLgbtWhip\Api\Model\Constituency;



/**
 * MapItClient
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class MapItClient extends AbstractRestServiceClient implements PostcodeToConstituencyMappingInterface
{
    
    /**
     *
     * @var MapItProcessorInterface
     */
    protected $processor;
    
    
    
    /**
     * 
     * @param Client $httpClient
     * @param MapItProcessorInterface $processor
     */
    public function __construct(
        Client $httpClient,
        MapItProcessorInterface $processor
    ) {
        parent::__construct($httpClient);
        
        $this->processor = $processor;
    }
    
    /**
     * 
     * @param string $postcode
     * @return Constituency
     */
    public function getConstituencyFromPostcode($postcode)
    {
        return $this->processor->processConstituencyData(
            $this->httpClient->get('/postcode/' . $postcode)
        );
    }
}
