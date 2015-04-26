<?php
/**
 * CandidateIssueVoteCheckerInterface.php
 * Definition of interface CandidateIssueVoteCheckerInterface
 * 
 * Created 26-Apr-2015 00:13:44
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External;

use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Issue;



/**
 * CandidateIssueVoteCheckerInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface CandidateIssueVoteCheckerInterface
{
    
    /**
     * 
     * @param Candidate $candidate
     * @param Issue $issue
     * @return boolean
     */
    public function checkCandidateCouldHaveVoted(
        Candidate $candidate,
        Issue $issue
    );
    
}
