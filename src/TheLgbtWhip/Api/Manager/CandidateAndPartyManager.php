<?php
/**
 * CandidateAndPartyManager.php
 * Definition of class CandidateAndPartyManager
 * 
 * Created 20-Apr-2015 18:20:45
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Party;
use TheLgbtWhip\Api\Repository\CandidateRepository;
use TheLgbtWhip\Api\Repository\PartyRepository;



/**
 * CandidateAndPartyManager
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CandidateAndPartyManager extends AbstractModelManager
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
     * @param ObjectManager $objectManager
     * @param CandidateRepository $candidateRepository
     * @param PartyRepository $partyRepository
     */
    public function __construct(
        ObjectManager $objectManager,
        CandidateRepository $candidateRepository,
        PartyRepository $partyRepository
    ) {
        parent::__construct($objectManager);
        
        $this->candidateRepository = $candidateRepository;
        $this->partyRepository = $partyRepository;
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @return Candidate
     */
    public function saveCandidate(Candidate $candidate)
    {
        return $this->mergeOrPersistObject($candidate);
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
    
}
