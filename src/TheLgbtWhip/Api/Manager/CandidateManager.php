<?php
/**
 * CandidateManager.php
 * Definition of class CandidateManager
 * 
 * Created 20-Apr-2015 18:20:45
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Model\Party;
use TheLgbtWhip\Api\Model\Term;
use TheLgbtWhip\Api\Model\View;
use TheLgbtWhip\Api\Model\Vote;
use TheLgbtWhip\Api\Repository\CandidateRepository;
use TheLgbtWhip\Api\Repository\PartyRepository;
use TheLgbtWhip\Api\Repository\VoteRepository;



/**
 * CandidateManager
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CandidateManager extends AbstractModelManager
{
    /**
     *
     * @var CandidateRepository
     */
    protected $candidateRepository;
    
    /**
     *
     * @var PartyRepository 
     */
    protected $partyRepository;
    
    /**
     *
     * @var VoteRepository
     */
    protected $voteRepository;
    
    
    
    
    /**
     * 
     * @param ObjectManager $objectManager
     * @param CandidateRepository $candidateRepository
     * @param PartyRepository $partyRepository
     * @param VoteRepository $voteRepository
     */
    public function __construct(
        ObjectManager $objectManager,
        CandidateRepository $candidateRepository,
        PartyRepository $partyRepository,
        VoteRepository $voteRepository
    ) {
        parent::__construct($objectManager);
        
        $this->candidateRepository = $candidateRepository;
        $this->partyRepository = $partyRepository;
        $this->voteRepository = $voteRepository;
    }
    
    /**
     * 
     * @param integer $id
     * @return Candidate|null
     */
    public function findOneById($id)
    {
        return $this->candidateRepository->find($id);
    }
    
    /**
     * 
     * @param string $name
     * @return Candidate|null
     */
    public function findOneByName($name)
    {
        return $this->candidateRepository->findOneByName($name);
    }
    
    /**
     * 
     * @param string $name
     * @param Constituency $constituency
     * @return Candidate
     */
    public function findOneByNameAndConstituency($name, Constituency $constituency)
    {
        return $this->candidateRepository->findOneByNameAndConstituency(
            $name,
            $constituency
        );
    }
    
    /**
     * 
     * @param Term $term
     * @return Term
     */
    public function saveTerm(Term $term)
    {
        return $this->mergeOrPersistObject($term);
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @param boolean $mergeIfExists
     * @return Candidate
     */
    public function saveCandidate(Candidate $candidate, $mergeIfExists = false)
    {
        if ($mergeIfExists === true) {
            return $this->mergeOrPersistObject($candidate);
        }
        
        $candidateId = $candidate->getId();
        
        if (($existingCandidate = $this->candidateRepository->find($candidateId)) instanceof Candidate) {
            return $existingCandidate;
        }
        
        $this->objectManager->persist($candidate);
        $this->objectManager->flush($candidate);
        
        return $candidate;
    }
    
    /**
     * 
     * @param Party $party
     * @return Party
     */
    public function saveParty(Party $party)
    {
        $partyId = $party->getId();
        
        if (
            $partyId !== null
            && ($existingParty = $this->partyRepository->find($partyId)) instanceof Party
        ) {
            return $existingParty;
        }
        
        $this->objectManager->persist($party);
        $this->objectManager->flush($party);
        
        return $party;
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
