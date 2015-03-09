<?php
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use Doctrine\ORM\EntityManager;
use Exception;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Model\Issue;
use TheLgbtWhip\Api\Model\Vote;
use TheLgbtWhip\Api\Repository\CandidateRepository;
use TheLgbtWhip\Api\Repository\ConstituencyRepository;



/**
 * Description of ThePublicWhipPersistingProcessor
 *
 * @author matt
 */
class ThePublicWhipPersistingProcessor implements ThePublicWhipProcessorInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $entityManager;
    
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
     * @var ThePublicWhipProcessorInterface
     */
    protected $realProcessor;
    
    
    
    /**
     * 
     * @param EntityManager $entityManager
     * @param CandidateRepository $candidateRepository
     * @param ConstituencyRepository $constituencyRepository
     * @param ThePublicWhipProcessorInterface $realProcessor
     */
    public function __construct(
        EntityManager $entityManager,
        CandidateRepository $candidateRepository,
        ConstituencyRepository $constituencyRepository,
        ThePublicWhipProcessorInterface $realProcessor
    ) {
        $this->entityManager = $entityManager;
        $this->candidateRepository = $candidateRepository;
        $this->constituencyRepository = $constituencyRepository;
        $this->realProcessor = $realProcessor;
    }
    
    /**
     * 
     * @param Issue $issue
     * @param array $votes
     */
    public function processVoteData(Issue $issue, array $votes)
    {
        $issue = $this->lazyPersistIssue($issue);

        if ($issue->getVotes()->count() > 0) {
            return $issue;
        }

        $this->entityManager->beginTransaction();

        try {

            /* @var $vote Vote */
            foreach ($this->realProcessor->processVoteData($issue, $votes) as $vote) {
                
                $candidate = $this->lazyPersistCandidate(
                    $vote->getCandidate()
                );
                
                $this->lazyPersistConstituency(
                    $candidate->getConstituency()
                );
                
                $this->persistVote(
                    $vote
                        ->setCandidate($candidate)
                        ->setIssue($issue)
                );
            }
            
            $this->entityManager->commit();
            
        } catch (Exception $ex) {
            $this->entityManager->rollback();
        }
        
        return $votes;
    }
    
    /**
     * 
     * @param Issue $issue
     * @return Issue
     */
    protected function lazyPersistIssue(Issue $issue)
    {
        if ($issue->getId() === null) {
            $this->entityManager->persist($issue);
            $this->entityManager->flush($issue);
        }
        
        return $issue;
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @return Candidate
     */
    protected function lazyPersistCandidate(Candidate $candidate)
    {
        $existingCandidate = $this->candidateRepository->findOneByName(
            $candidate->getName()
        );
        
        if ($existingCandidate instanceof Candidate) {
            return $existingCandidate;
        }
        
        $this->entityManager->persist($candidate);
        $this->entityManager->flush($candidate);
        
        return $candidate;
    }
    
    /**
     * 
     * @param Constituency $constituency
     * @return Constituency
     */
    protected function lazyPersistConstituency(Constituency $constituency)
    {
        $existingConstituency = $this->constituencyRepository->findOneByName(
            $constituency->getName()
        );
        
        if ($existingConstituency instanceof Constituency) {
            return $existingConstituency;
        }
        
        $this->entityManager->persist($constituency);
        $this->entityManager->flush($constituency);
        
        return $constituency;
    }
    
    /**
     * 
     * @param Vote $vote
     * @return Vote
     */
    protected function persistVote(Vote $vote)
    {
        $this->entityManager->persist($vote);
        $this->entityManager->flush($vote);
        
        return $vote;
    }
    
}
