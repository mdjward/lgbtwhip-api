<?php
/**
 * CandidateVoteRetrieverInterface.php
 * Definition of interface CandidateVoteRetrieverInterface
 * 
 * Created 23-Apr-2015 13:23:48
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External;

use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Issue;



/**
 * CandidateVoteRetrieverInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface CandidateVoteRetrieverInterface
{
    
    /**
     * 
     * @param Candidate $candidate
     * @return Vote|null
     */
    public function getVoteForCandidate(
        Candidate $candidate,
        Issue $issue
    );
    
}
