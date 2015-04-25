<?php
/**
 * CandidateIssueManager.php
 * Definition of class CandidateIssueManager
 * 
 * Created 23-Apr-2015 13:28:38
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use TheLgbtWhip\Api\Model\View;
use TheLgbtWhip\Api\Model\Vote;
use TheLgbtWhip\Api\Repository\CandidateRepository;
use TheLgbtWhip\Api\Repository\VoteRepository;



/**
 * CandidateIssueManager
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CandidateIssueManager extends AbstractModelManager
{
    
    /**
     *
     * @var CandidateRepository
     */
    protected $candidateRepository;
    
    /**
     *
     * @var VoteRepository
     */
    protected $voteRepository;
    
    
    
    /**
     * 
     * @param ObjectManager $objectManager
     * @param CandidateRepository $candidateRepository
     * @param VoteRepository $voteRepository
     */
    public function __construct(
        ObjectManager $objectManager,
        CandidateRepository $candidateRepository,
        VoteRepository $voteRepository
    ) {
        parent::__construct($objectManager);
        
        $this->candidateRepository = $candidateRepository;
        $this->voteRepository = $voteRepository;
    }
    
    /**
     * 
     * @param View $view
     * @return View
     */
    public function saveView(View $view)
    {
        return $this->mergeOrPersistObject($view);
    }
    
    /**
     * 
     * @param Vote $vote
     * @return Vote
     */
    public function saveVote(Vote $vote)
    {
        $existingVote = $this->voteRepository->findOneByCandidateAndIssue(
            $vote->getCandidate(),
            $vote->getIssue()
        );
        
        if ($existingVote instanceof $vote) {
            return $existingVote;
        }
        
        $this->objectManager->persist($vote);
        $this->objectManager->flush($vote);
        
        return $vote;
    }
    
}
