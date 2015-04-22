<?php
/**
 * VoteRetrieverInterface.php
 * Definition of interface VoteRetrieverInterface
 * 
 * Created 21-Apr-2015 18:57:11
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External;

use TheLgbtWhip\Api\Model\Issue;



/**
 * VoteRetrieverInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface VoteRetrieverInterface
{
    
    /**
     * 
     * @param Issue $issue
     * @return array
     */
    public function getVotesForIssue(Issue $issue);
    
}
