<?php
/**
 * CandidateAdapter.php
 * Definition of class CandidateAdapter
 * 
 * Created 24-Apr-2015 09:13:00
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Adapter;

use TheLgbtWhip\Api\Model\Adapted\Candidate as AdaptedCandidate;
use TheLgbtWhip\Api\Model\Adapted\Issue as AdaptedIssue;
use TheLgbtWhip\Api\Model\Candidate;



/**
 * CandidateAdapter
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CandidateAdapter implements CandidateAdapterInterface
{
    
    /**
     *
     * @var IssueAdapterInterface
     */
    protected $issueAdapter;
    
    
    
    /**
     * 
     * @param \TheLgbtWhip\Api\Adapter\IssueAdapterInterface $issueAdapter
     */
    public function __construct(IssueAdapterInterface $issueAdapter)
    {
        $this->issueAdapter = $issueAdapter;
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @return AdaptedCandidate
     */
    public function adaptCandidate(Candidate $candidate)
    {
        $adaptedCandidate = new AdaptedCandidate();
        
        $adaptedCandidate
            ->setName($candidate->getName())
            ->setEmail($candidate->getEmail())
            ->setConstituency($candidate->getConstituency())
            ->setParty($candidate->getParty())
            ->setPhoto($candidate->getPhoto())
            ->setWebsite($candidate->getWebsite())
            ->setWikipedia($candidate->getWikipedia())
            ->setTwitter($candidate->getTwitter())
            ->setId($candidate->getId())
        ;
        
        foreach ($candidate->getTermsAsMp() as $term) {
            $adaptedCandidate->addTermAsMp($term);
        }
        
        /* @var $issue AdaptedIssue */
        foreach ($this->issueAdapter->adaptVotesAndViews($candidate) as $issue) {
            $adaptedCandidate->addIssue($issue);
        }
        
        return $adaptedCandidate;
    }
    
}
