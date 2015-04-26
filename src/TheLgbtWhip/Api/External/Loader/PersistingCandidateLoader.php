<?php
/**
 * PersistingCandidateLoader.php
 * Definition of class PersistingCandidateLoader
 * 
 * Created 26-Apr-2015 16:13:05
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Loader;

use TheLgbtWhip\Api\Cache\Cacheable;
use TheLgbtWhip\Api\Cache\CacheableTrait;
use TheLgbtWhip\Api\External\CandidateIdResolverInterface;
use TheLgbtWhip\Api\External\CandidateIssueVoteCheckerInterface;
use TheLgbtWhip\Api\External\CandidateNameResolverInterface;
use TheLgbtWhip\Api\External\CandidateNameSearcherInterface;
use TheLgbtWhip\Api\External\ConstituencyCandidatesRetrieverInterface;
use TheLgbtWhip\Api\External\Loader\AbstractCandidateLoader;
use TheLgbtWhip\Api\External\PastMpTermRetrieverInterface;
use TheLgbtWhip\Api\Manager\CandidateManager;
use TheLgbtWhip\Api\Manager\ConstituencyManager;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;



/**
 * PersistingCandidateLoader
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class PersistingCandidateLoader
    extends AbstractCandidateLoader
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
     * @var CandidateIssueManager
     */
    protected $candidateManager;
    
    
    
    /**
     * 
     * @param CandidateIdResolverInterface $candidateIdResolver
     * @param CandidateNameResolverInterface $candidateNameResolver
     * @param CandidateNameSearcherInterface $candidateNameSearcher
     * @param ConstituencyCandidatesRetrieverInterface $constituencyCandidatesRetriever
     * @param CandidateIssueVoteCheckerInterface $candidateIssueVoteChecker
     * @param PastMpTermRetrieverInterface $pastMpTermsRetriever
     * @param ConstituencyManager $constituencyManager
     * @param CandidateManager $candidateManager
     */
    public function __construct(
        CandidateIdResolverInterface $candidateIdResolver,
        CandidateNameResolverInterface $candidateNameResolver,
        CandidateNameSearcherInterface $candidateNameSearcher,
        ConstituencyCandidatesRetrieverInterface $constituencyCandidatesRetriever,
        CandidateIssueVoteCheckerInterface $candidateIssueVoteChecker,
        PastMpTermRetrieverInterface $pastMpTermsRetriever,
        ConstituencyManager $constituencyManager,
        CandidateManager $candidateManager
    ) {
        parent::__construct(
            $candidateIdResolver,
            $candidateNameResolver,
            $candidateNameSearcher,
            $constituencyCandidatesRetriever,
            $candidateIssueVoteChecker,
            $pastMpTermsRetriever
        );
        
        $this->constituencyManager = $constituencyManager;
        $this->candidateManager = $candidateManager;
    }
    
    public function getCandidatesForConstituency(Constituency $constituency)
    {
        $candidates = $this->constituencyCandidatesRetriever->getCandidatesForConstituency(
            $this->constituencyManager->saveConstituency($constituency)
        );
        
        foreach ($candidates as $candidate) {
            $this->hydrateCandidatesWithTermsAndVotes($candidate);
        }
        
        return $candidates;
    }
    
    public function resolveCandidateById($candidateId)
    {
        return $this->hydrateCandidatesWithTermsAndVotes(
            $this->candidateIdResolver->resolveCandidateById($candidateId)
        );
    }
    
    public function resolveCandidateByName($candidateName)
    {
        return $this->hydrateCandidatesWithTermsAndVotes(
            $this->candidateNameResolver->resolveCandidateByName($candidateName)
        );
    }
    
    protected function hydrateCandidatesWithTermsAndVotes(Candidate $candidate)
    {
        foreach ($this->pastMpTermsRetriever->findPastTermsForCandidate($candidate) as $term) {
            $candidate->addTermAsMp($term);
        }
        
        return $candidate;
    }
    
}
