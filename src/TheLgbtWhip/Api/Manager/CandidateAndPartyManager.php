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
     * @param ObjectManager $objectManager
     * @param CandidateRepository $candidateRepository
     */
    public function __construct(
        ObjectManager $objectManager,
        CandidateRepository $candidateRepository
    ) {
        parent::__construct($objectManager);
        
        $this->candidateRepository = $candidateRepository;
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
        return $this->mergeOrPersistObject($party);
    }
    
}
