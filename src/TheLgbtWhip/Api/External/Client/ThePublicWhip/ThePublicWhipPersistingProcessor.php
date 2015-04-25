<?php
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use BadMethodCallException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use TheLgbtWhip\Api\Manager\CandidateIssueManager;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Model\Issue;
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
     * @param EntityManagerInterface $entityManager
     * @param CandidateRepository $candidateRepository
     * @param ConstituencyRepository $constituencyRepository
     * @param ThePublicWhipProcessorInterface $realProcessor
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        CandidateRepository $candidateRepository,
        ConstituencyRepository $constituencyRepository,
        CandidateIssueManager $candidateIssueManager
    ) {
        $this->entityManager = $entityManager;
        $this->candidateRepository = $candidateRepository;
        $this->constituencyRepository = $constituencyRepository;
        $this->candidateIssueManager = $candidateIssueManager;
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
     * @throws BadMethodCallException
     */
    protected function buildConstituency(array $voteData)
    {
        throw new BadMethodCallException(
            'Constituency construction is not supported in this implementation'
        );
    }
    
}
