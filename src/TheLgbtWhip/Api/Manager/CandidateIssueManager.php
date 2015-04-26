<?php
/**
 * CandidateManager.php
 * Definition of class CandidateManager
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
    
}
