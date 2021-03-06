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
        
        foreach ($votes as $key => $voteData)
        {
            $processedVotes[$key] = $this->buildVote(
                $voteData,
                $this->buildCandidate(
                    $voteData,
                    $this->buildConstituency($voteData)
                ),
                $issue
            );
        }
        
        return $processedVotes;
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @param array $votes
     * @return null
     */
    public function findCandidateInVotes(Candidate $candidate, array $votes)
    {
        $constituency = $candidate->getConstituency();
        
        $key = $candidate->getName() . ' - ' . $constituency->getName();
        
        if (isset($votes[$key])) {
            return $votes[$key];
        }
        
        return null;
    }
    
    /**
     * 
     * @param array $voteData
     * @return Constituency
     */
    protected function buildConstituency(array $voteData)
    {
        $constituency = new Constituency();
        
        return $constituency->setName($voteData['constituency']);
    }
    
    /**
     * 
     * @param array $voteData
     * @param Constituency $constituency
     * @return Candidate
     */
    protected function buildCandidate(array $voteData, Constituency $constituency)
    {
        $candidate = new Candidate();
        
        return $candidate
            ->setName($voteData['name'])
            ->setConstituency($constituency)
        ;
    }
    
    protected function buildVote(
        array $voteData,
        Candidate $candidate,
        Issue $issue
    ) {
        $vote = new Vote();
        
        return $vote
            ->setIssue($issue)
            ->setCandidate($candidate)
            ->setVoteCast($voteData['voteCast'])
        ;
    }
    
}
