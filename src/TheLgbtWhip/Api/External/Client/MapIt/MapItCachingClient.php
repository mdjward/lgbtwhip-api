<?php
/**
 * MapItCachingClient.php
 * Definition of class MapItCachingClient
 * 
 * Created 22-Apr-2015 00:07:45
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client\MapIt;

use TheLgbtWhip\Api\Cache\Cacheable;
use TheLgbtWhip\Api\Cache\CacheableTrait;
use TheLgbtWhip\Api\External\Client\AbstractRestServiceClient;
use TheLgbtWhip\Api\External\PostcodeToConstituencyMappingInterface;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Repository\ConstituencyRepository;



/**
 * MapItCachingClient
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class MapItCachingClient extends AbstractRestServiceClient implements PostcodeToConstituencyMappingInterface, Cacheable
{
    use CacheableTrait;
    
    /**
     *
     * @var MapItClient
     */
    protected $realClient;
    
    /**
     *
     * @var ConstituencyRepository
     */
    protected $constituencyRepository;
    
    
    
    /**
     * 
     * @param MapItClient $realClient
     * @param ConstituencyRepository $constituencyRepository
     */
    public function __construct(
        MapItClient $realClient,
        ConstituencyRepository $constituencyRepository
    ) {
        $this->realClient = $realClient;
        $this->constituencyRepository = $constituencyRepository;
    }
    
    /**
     * 
     * @param string $postcode
     * @return Constituency
     */
    public function getConstituencyFromPostcode($postcode)
    {
        if ($this->cache !== null && $this->cache->contains($postcode)) {
            return $this->constituencyRepository->find(
                $this->cache->fetch($postcode)
            );
        }
        
        $result = $this->realClient->getConstituencyFromPostcode($postcode);
        
        $this->cache->save($postcode, $result->getId());
        
        return $result;
    }
    
}
