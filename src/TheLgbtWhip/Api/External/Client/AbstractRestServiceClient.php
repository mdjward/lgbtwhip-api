<?php
/**
 * AbstractRestServiceClient.php
 * Definition of class AbstractRestServiceClient
 * 
 * Created 01-Mar-2015 15:22:11
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client;

use GuzzleHttp\Client;



/**
 * AbstractRestServiceClient
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
abstract class AbstractRestServiceClient
{
    
    /**
     *
     * @var Client
     */
    protected $httpClient;
    
    
    
    /**
     * 
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    
}
