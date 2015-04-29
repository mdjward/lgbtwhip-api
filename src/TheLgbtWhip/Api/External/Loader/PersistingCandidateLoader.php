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

use Exception;
use TheLgbtWhip\Api\Cache\Cacheable;
use TheLgbtWhip\Api\Cache\CacheableTrait;
use TheLgbtWhip\Api\External\CandidateIdResolverInterface;
use TheLgbtWhip\Api\External\CandidateIssueVoteCheckerInterface;
use TheLgbtWhip\Api\External\CandidateNameResolverInterface;
use TheLgbtWhip\Api\External\CandidateNameSearcherInterface;
use TheLgbtWhip\Api\External\CandidateVoteRetrieverInterface;
use TheLgbtWhip\Api\External\ConstituencyCandidatesRetrieverInterface;
use TheLgbtWhip\Api\External\Loader\AbstractCandidateLoader;
use TheLgbtWhip\Api\External\PastMpTermRetrieverInterface;
use TheLgbtWhip\Api\Manager\CandidateManager;
use TheLgbtWhip\Api\Manager\ConstituencyManager;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Model\Vote;
use TheLgbtWhip\Api\Repository\IssueRepository;



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
     * @var IssueRepository
     */
    protected $issueRepository;
    
    
    
    /**
     * 
     * @param CandidateIdResolverInterface $candidateIdResolver
     * @param CandidateNameResolverInterface $candidateNameResolver
     * @param CandidateNameSearcherInterface $candidateNameSearcher
     * @param ConstituencyCandidatesRetrieverInterface $constituencyCandidatesRetriever
     * @param CandidateIssueVoteCheckerInterface $candidateIssueVoteChecker
     * @param CandidateVoteRetrieverInterface $candidateVoteRetriever
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
        CandidateVoteRetrieverInterface $candidateVoteRetriever,
        PastMpTermRetrieverInterface $pastMpTermsRetriever,
        ConstituencyManager $constituencyManager,
        CandidateManager $candidateManager,
        IssueRepository $issueRepository
    ) {
        parent::__construct(
            $candidateIdResolver,
            $candidateNameResolver,
            $candidateNameSearcher,
            $constituencyCandidatesRetriever,
            $candidateIssueVoteChecker,
            $candidateVoteRetriever,
            $pastMpTermsRetriever
        );
        
        $this->constituencyManager = $constituencyManager;
        $this->candidateManager = $candidateManager;
        $this->issueRepository = $issueRepository;
    }
    
    public function getCandidatesForConstituency(Constituency $constituency)
    {
        $candidates = $this->constituencyCandidatesRetriever->getCandidatesForConstituency(
            $this->constituencyManager->saveConstituency($constituency)
        );
        
        foreach ($candidates as $candidate) {
            $this->hydrateCandidate($candidate);
        }
        
        return $candidates;
    }
    
    public function resolveCandidateById($candidateId)
    {
        $candidate = $this->candidateManager->findOneById($candidateId);
        
        if (!($candidate instanceof Candidate)) {
            $candidate = $this->persistCandidate(
                $this->candidateNameResolver->resolveCandidateById($candidateId)
            );
        }
        
        return $this->hydrateCandidate($candidate);
    }
    
    /**
     * 
     * @param type $candidateName
     * @return type
     */
    public function resolveCandidateByName($candidateName)
    {
        $candidate = $this->candidateManager->findOneByName($candidateName);
        
        if (!($candidate instanceof Candidate)) {
            $candidate = $this->persistCandidate(
                $this->candidateNameResolver->resolveCandidateByName($candidateName)
            );
        }
        
        return $this->hydrateCandidate($candidate);
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @return Candidate
     */
    protected function persistCandidate(Candidate $candidate)
    {
        $candidate
            ->setParty(
                $this->candidateManager->saveParty($candidate->getParty())
            )
            ->setConstituency(
                $this->constituencyManager->saveConstituency($candidate->getConstituency())
            )
        ;
        
        return $this->candidateManager->saveCandidate($candidate);
    }
    
    protected function hydrateCandidate(Candidate $candidate)
    {
        $loadedCandidate = $this->candidateManager->findOneById($candidate->getId());
        if (!($loadedCandidate instanceof Candidate)) {
            return $candidate;
        }
        
        $cache = $this->getCache();
        $cacheKey = 'hydrated-' . $candidate->getId();
        
        if ($cache->contains($cacheKey)) {
            return $candidate;
        }
        
        $this->hydrateCandidateWithTerms($candidate);
        $this->hydrateCandidateWithVotes($candidate);
        
        $cache->save($cacheKey, $cache);
        
        return $candidate;
    }
    
    protected function hydrateCandidateWithTerms(Candidate $candidate)
    {
        $terms = [];
        
        foreach ($this->pastMpTermsRetriever->findPastTermsForCandidate($candidate) as $term) {
            try{
                $this->candidateManager->saveTerm($term);
                $terms[] = $term;
            } catch (Exception $ex) {
            }
            
        }
        
        return $terms;
    }
    
    protected function hydrateCandidateWithVotes(Candidate $candidate)
    {
        foreach ($this->issueRepository->findAll() as $issue) {
            if (!$this->candidateIssueVoteChecker->checkCandidateCouldHaveVoted($candidate, $issue)) {
                continue;
            }

            $vote = $this->candidateVoteRetriever->getVoteForCandidate(
                $candidate,
                $issue
            );

            /* @var $vote Vote */
            if ($vote !== null) {
                try {
                    $this->candidateManager->saveVote(
                        $vote->setCandidate(
                            $this->candidateManager->findOneById(
                                $candidate->getId()
                            )
                        )
                    );
                } catch (Exception $ex) {
                }
            }
        }
        
        return $candidate;
    }
    
}
