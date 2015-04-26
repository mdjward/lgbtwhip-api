<?php
/**
 * PersistingConstituencyLoader.php
 * Definition of class PersistingConstituencyLoader
 * 
 * Created 26-Apr-2015 12:00:23
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Loader;

use TheLgbtWhip\Api\Cache\Cacheable;
use TheLgbtWhip\Api\Cache\CacheableTrait;
use TheLgbtWhip\Api\External\AllConstituenciesRetrieverInterface;
use TheLgbtWhip\Api\External\ConstituencyCandidatesRetrieverInterface;
use TheLgbtWhip\Api\External\ConstituencyIdResolverInterface;
use TheLgbtWhip\Api\External\ConstituencyNameResolverInterface;
use TheLgbtWhip\Api\External\Loader\AbstractConstituencyLoader;
use TheLgbtWhip\Api\External\PostcodeToConstituencyMappingInterface;
use TheLgbtWhip\Api\Manager\CandidateManager;
use TheLgbtWhip\Api\Manager\ConstituencyManager;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;



/**
 * PersistingConstituencyLoader
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class PersistingConstituencyLoader
    extends AbstractConstituencyLoader
    implements Cacheable
{
    use CacheableTrait;
    
    /**
     *
     * @var ConstituencyManager
     */
    protected $constituencyManager;
    
    /**
     *
     * @var CandidateManager
     */
    protected $candidateAndPartyManager;
    
    
    
    /**
     * 
     * @param AllConstituenciesRetrieverInterface $allConstituenciesRetriever
     * @param PostcodeToConstituencyMappingInterface $postcodeConstituencyMapper
     * @param ConstituencyIdResolverInterface $constituencyIdResolver
     * @param ConstituencyNameResolverInterface $constituencyNameResolver
     * @param ConstituencyCandidatesRetrieverInterface $constituencyCandidatesRetriever
     * @param ConstituencyManager $constituencyManager
     * @param CandidateManager $candidateAndPartyManager
     */
    public function __construct(
        AllConstituenciesRetrieverInterface $allConstituenciesRetriever,
        PostcodeToConstituencyMappingInterface $postcodeConstituencyMapper,
        ConstituencyIdResolverInterface $constituencyIdResolver,
        ConstituencyNameResolverInterface $constituencyNameResolver,
        ConstituencyCandidatesRetrieverInterface $constituencyCandidatesRetriever,
        ConstituencyManager $constituencyManager,
        CandidateManager $candidateAndPartyManager
    ) {
        parent::__construct(
            $allConstituenciesRetriever,
            $postcodeConstituencyMapper,
            $constituencyIdResolver,
            $constituencyNameResolver,
            $constituencyCandidatesRetriever
        );
        
        $this->constituencyManager = $constituencyManager;
        $this->candidateAndPartyManager = $candidateAndPartyManager;
    }
    
    /**
     * 
     * @return array
     */
    public function getAllConstituencies()
    {
        $cache = $this->getCache();
        $cacheKey = 'total-constituencies';
        
        if ($cache->contains($cacheKey)) {
            return $this->constituencyManager->findAll();
        }
        
        $constituencies = [];
        $total = 0;
        
        foreach ($this->allConstituenciesRetriever->getAllConstituencies() as $constituency) {
            $constituencies[] = $this->persistConstituencyAndCandidates($constituency);
            
            $total++;
        }
        
        $cache->save($cacheKey, $total);
        
        return $constituencies;
    }
    
    /**
     * 
     * @param string $postcode
     * @return Constituency
     */
    public function getConstituencyFromPostcode($postcode)
    {
        $cache = $this->getCache();
        $cacheKey = 'postcode-' . $postcode;

        if ($cache->contains($cacheKey)) {
            return $this->constituencyManager->findOneById(
                $cache->fetch($cacheKey)
            );
        }
        
        $constituency = $this->persistConstituencyAndCandidates(
            $this->postcodeConstituencyMapper->getConstituencyFromPostcode(
                $postcode
            )
        );
        
        $cache->save($cacheKey, $constituency->getId());
        
        return $constituency;
    }
    
    /**
     * 
     * @param integer $constituencyId
     * @return Constituency
     */
    public function resolveConstituencyById($constituencyId)
    {
        $constituency = $this->constituencyManager->findOneById($constituencyId);
        
        if ($constituency instanceof Constituency) {
            return $constituency;
        }
        
        return $this->persistConstituencyAndCandidates(
            $this->constituencyIdResolver->resolveConstituencyById(
                $constituencyId
            )
        );
    }
    
    /**
     * 
     * @param string $constituencyName
     * @return Constituency
     */
    public function resolveConstituencyByName($constituencyName)
    {
        $constituency = $this->constituencyManager->findOneByName($constituencyName);
        
        if ($constituency instanceof Constituency) {
            return $constituency;
        }
        
        return $this->persistConstituencyAndCandidates(
            $this->constituencyNameResolver->resolveConstituencyByName(
                $constituencyName
            )
        );
    }
    
    /**
     * 
     * @param Constituency|null $constituency
     * @return Constituency|null
     */
    protected function persistConstituencyAndCandidates(Constituency $constituency = null)
    {
        if ($constituency !== null) {
            return $this->populateConstituencyWithCandidates(
                $this->constituencyManager->saveConstituency($constituency)
            );
        }
        
        return null;
    }
    
    /**
     * 
     * @param Constituency $constituency
     * @return Constituency
     */
    protected function populateConstituencyWithCandidates(Constituency $constituency)
    {
        /* @var $candidate Candidate */
        foreach ($this->constituencyCandidatesRetriever->getCandidatesForConstituency($constituency) as $candidate) {
            
            /* 
             * Persist the party first, and set the managed object within the
             * candidate prior to persisting the candidate
             */
            $this->candidateAndPartyManager->saveCandidate(
                $candidate->setParty(
                    $this->candidateAndPartyManager->saveParty(
                        $candidate->getParty() 
                    )
                )
            );
            
            $constituency->addCandidate($candidate);
        }
        
        return $constituency;
    }
    
}

