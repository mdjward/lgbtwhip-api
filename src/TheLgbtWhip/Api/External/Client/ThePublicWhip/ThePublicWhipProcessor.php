<?php
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Model\Issue;
use TheLgbtWhip\Api\Model\Vote;



/**
 * Description of ThePublicWhipProcessor
 *
 * @author matt
 */
class ThePublicWhipProcessor implements ThePublicWhipProcessorInterface
{
    
    /**
     * 
     * @param array $votes
     * @return array
     */
    public function processVoteData(Issue $issue, array $votes)
    {
        $processedVotes = [];
        
        foreach ($votes as $voteData)
        {
            $constituency = new Constituency();
            $constituency->setName($voteData['constituency']);
            
            $candidate = new Candidate();
            $candidate
                ->setConstituency($constituency)
                ->setName($voteData['name'])
            ;
            
            $vote = new Vote();
            $vote
                ->setIssue($issue)
                ->setCandidate($candidate)
                ->setVoteCast($voteData['voteCast'])
            ;
            
            $processedVotes[] = $processedVotes;
        }
        
        return $processedVotes;
    }
    
}
