<?php
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use TheLgbtWhip\Api\Model\Issue;

/**
 * Description of ThePublicWhipProcessorInterface
 *
 * @author matt
 */
interface ThePublicWhipProcessorInterface
{
    
    /**
     * 
     */
    const VOTE_DATA_KEY_NAME = 'name';
    
    /**
     * 
     */
    const VOTE_DATA_KEY_CONSTITUENCY = 'constituency';
    
    /**
     * 
     */
    const VOTE_DATA_KEY_VOTE_CAST = 'voteCast';
    
    
    /**
     * 
     * @param Issue $issue
     * @param array $votes
     */
    public function processVoteData(Issue $issue, array $votes);
    
}
