<?php
/**
 * YourNextMpCachingClient.php
 * Definition of class YourNextMpCachingClient
 * 
 * Created 23-Apr-2015 03:11:20
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client\YourNextMp;

use Doctrine\Common\Persistence\ObjectManager;
use GuzzleHttp\Client;
use TheLgbtWhip\Api\Cache\Cacheable;
use TheLgbtWhip\Api\Cache\CacheableTrait;
use TheLgbtWhip\Api\Repository\CandidateRepository;
use TheLgbtWhip\Api\Repository\ConstituencyRepository;



/**
 * YourNextMpCachingClient
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class YourNextMpCachingClient extends YourNextMpClient implements Cacheable
{
    use CacheableTrait;
    
    
    
    /**
     *
     * @var ObjectManager
     */
    protected $objectManager;
    
    /**
     *
     * @var CandidateRepository
     */
    protected $candidateRepository;

    /**
     *
     * @var ConstituencyRepository
     */
    protected $constituencyRepository;
    
    
    
    /**
     * 
     * @param Client $httpClient
     * @param YourNextMpProcessorInterface $processor
     * @param ObjectManager $objectManager
     * @param CandidateRepository $candidateRepository
     * @param ConstituencyRepository $constituencyRepository
     */
    public function __construct(
        Client $httpClient,
        YourNextMpProcessorInterface $processor,
        ObjectManager $objectManager,
        CandidateRepository $candidateRepository,
        ConstituencyRepository $constituencyRepository
    ) {
        parent::__construct($httpClient, $processor);
        
        $this->objectManager = $objectManager;
        $this->candidateRepository = $candidateRepository;
        $this->constituencyRepository = $constituencyRepository;
    }
    
    public function resolveCandidateById($candidateId)
    {
        return parent::resolveCandidateById($candidateId);
    }
    
    public function resolveCandidateByName($candidateName)
    {
        return parent::resolveCandidateByName($candidateName);
    }
    
    public function resolveConstituencyById($constituencyId)
    {
        $cacheKey = 'constituency-id-' . $constituencyId;
        
        if ($this->cache !== null && $this->cache->contains($cacheKey)) {
            return $this->constituencyRepository->find(
                $this->cache->fetch($cacheKey)
            );
        }
        
        $constituency = parent::resolveConstituencyById($constituencyId);
        
        $this->cache->save(
            $cacheKey,
            $constituency->getId()
        );
        
        return $constituency;
    }
    
    public function resolveConstituencyByName($constituencyName)
    {
        $cacheKey = 'constituency-name-' . $constituencyName;
        
        if ($this->cache !== null && $this->cache->contains($cacheKey)) {
            return $this->constituencyRepository->findOneByName(
                $this->cache->fetch($cacheKey)
            );
        }
        
        $constituency = parent::resolveConstituencyByName($constituencyName);
        
        $this->cache->save(
            $cacheKey,
            $constituency->getName()
        );
        
        return $constituency;
    }
    
}
