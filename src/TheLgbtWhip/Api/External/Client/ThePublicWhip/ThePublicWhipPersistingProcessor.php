<?php
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use BadMethodCallException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use TheLgbtWhip\Api\External\CandidateIssueVoteCheckerInterface;
use TheLgbtWhip\Api\Manager\CandidateIssueManager;
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
class ThePublicWhipPersistingProcessor extends ThePublicWhipProcessor
{

    /**
     *
     * @var EntityManagerInterface
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
     * @var CandidateIssueManager
     */
    protected $candidateIssueManager;
    
    /**
     *
     * @var CandidateIssueVoteCheckerInterface 
     */
    protected $candidateIssueVoteChecker;
    
    
    
    /**
     * 
     * @param EntityManagerInterface $entityManager
     * @param CandidateRepository $candidateRepository
     * @param ConstituencyRepository $constituencyRepository
     * @param ThePublicWhipProcessorInterface $realProcessor
     * @param CandidateIssueVoteCheckerInterface $candidateIssueVoteChecker
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        CandidateRepository $candidateRepository,
        ConstituencyRepository $constituencyRepository,
        CandidateIssueManager $candidateIssueManager,
        CandidateIssueVoteCheckerInterface $candidateIssueVoteChecker
    ) {
        $this->entityManager = $entityManager;
        $this->candidateRepository = $candidateRepository;
        $this->constituencyRepository = $constituencyRepository;
        $this->candidateIssueManager = $candidateIssueManager;
        $this->candidateIssueVoteChecker = $candidateIssueVoteChecker;
    }
    
    /**
     * 
     * @param Issue $issue
     * @param array $votes
     */
    public function processVoteData(Issue $issue, array $votes)
    {
        if ($issue->getVotes()->count() > 0) {
            return $issue;
        }
        
        $this->entityManager->beginTransaction();
        
        try {
            parent::processVoteData($issue, $votes);
            
            $this->entityManager->commit();
            
        } catch (Exception $ex) {
            $this->entityManager->rollback();
        }
        
        return $votes;
    }
    
    /**
     * 
     * @param array $voteData
     * @param Constituency $constituency
     * @return Candidate
     */
    protected function buildCandidate(
        array $voteData,
        Constituency $constituency
    ) {
        $existingCandidate = $this->candidateRepository->findOneByNameAndConstituency(
            $voteData['name'],
            $constituency
        );
        
        if ($existingCandidate instanceof Candidate) {
            return $existingCandidate;
        }
        
        throw new CandidateNotStandingException($voteData['name']);
    }
    
    /**
     * 
     * @param array $voteData
     * @param Candidate $candidate
     * @param Issue $issue
     * @return Vote
     */
    protected function buildVote(
        array $voteData,
        Candidate $candidate,
        Issue $issue
    ) {
        return $this->candidateIssueManager->saveVote(
            parent::buildVote($voteData, $candidate, $issue)
        );
    }
    
    /**
     * 
     * @param array $voteData
     * @return Constituency|null
     */
    protected function buildConstituency(array $voteData)
    {
        return $this->constituencyRepository->findOneByName(
            $voteData['constituency']
        );
    }
    
}
