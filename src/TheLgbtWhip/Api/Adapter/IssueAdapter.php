<?php
/**
 * IssueAdapter.php
 * Definition of class IssueAdapter
 * 
 * Created 24-Apr-2015 09:28:13
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Adapter;

use TheLgbtWhip\Api\Model\Adapted\Issue as AdaptedIssue;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Issue;
use TheLgbtWhip\Api\Repository\IssueRepository;



/**
 * IssueAdapter
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class IssueAdapter implements IssueAdapterInterface
{
    
    /**
     *
     * @var IssueRepository
     */
    protected $issueRepository;
    
    
    
    /**
     * 
     * @param IssueRepository $issueRepository
     */
    public function __construct(IssueRepository $issueRepository)
    {
        $this->issueRepository = $issueRepository;
    }
    
    public function adaptVotesAndViews(Candidate $candidate)
    {
        $adaptedIssues = [];
        
        foreach ($candidate->getVotes() as $vote) {
            $adaptedIssues[$issue->getId()] = $this->buildAdaptedIssue(
                $issue,
                $candidate
            );
        }
        
        /* @var $candidate Issue */
        foreach ($this->issueRepository->findByCandidate($candidate) as $issue) {
            $adaptedIssues[$issue->getId()] = $this->buildAdaptedIssue(
                $issue,
                $candidate
            );
        }
        
        return $adaptedIssues;
    }
    
    protected function buildAdaptedIssue(Issue $issue)
    {
        $adaptedIssue = new AdaptedIssue();
        
        $adaptedIssue
            ->setTitle($issue->getTitle())
            ->setDescription($issue->getDescription())
            ->setRelevantAct($issue->getRelevantAct())
            ->setIsProgressiveStance($issue->getIsProgressiveStance())
            ->setPublicWhipId($issue->getPublicWhipId())
            ->setPublicWhipDate($issue->getPublicWhipDate())
            ->setUrl($issue->getUrl())
            ->setUriKey($issue->getUriKey())
        ;
        
        foreach ($issue->getVotes() as $vote) {
            $adaptedIssue->setVote($vote);
            break;
        }
        
        foreach ($issue->getViews() as $view) {
            $adaptedIssue->setView($view);
            break;
        }
        
        return $adaptedIssue;
    }
    
}
