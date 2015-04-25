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
     * @return array
     */
    public function getVotesForCandidate(Candidate $candidate);
    
}
