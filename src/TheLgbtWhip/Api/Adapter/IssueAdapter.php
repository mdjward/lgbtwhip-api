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
use TheLgbtWhip\Api\Model\View;
use TheLgbtWhip\Api\Model\Vote;
use TheLgbtWhip\Api\Repository\IssueRepository;
use TheLgbtWhip\Api\Repository\ViewRepository;
use TheLgbtWhip\Api\Repository\VoteRepository;



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
     * @var VoteRepository
     */
    protected $voteRepository;
    
    /**
     *
     * @var ViewRepository
     */
    protected $viewRepository;



    /**
     * 
     * @param IssueRepository $issueRepository
     * @param VoteRepository $voteRepository
     * @param ViewRepository $viewRepository
     */
    public function __construct(
        IssueRepository $issueRepository,
        VoteRepository $voteRepository,
        ViewRepository $viewRepository
    ) {
        $this->issueRepository = $issueRepository;
        $this->voteRepository = $voteRepository;
        $this->viewRepository = $viewRepository;
    }

    public function adaptVotesAndViews(Candidate $candidate)
    {
        $adaptedIssues = [];

        foreach ($candidate->getVotes() as $vote) {
            $issue = $vote->getIssue();
            
            $adaptedIssues[$issue->getId()] = $this->buildAdaptedIssue(
                $candidate,
                $issue
            );
        }

        /* @var $candidate Issue */
        foreach ($this->issueRepository->findByCandidate($candidate) as $issue) {
            $adaptedIssues[$issue->getId()] = $this->buildAdaptedIssue(
                $candidate,
                $issue
            );
        }

        return $adaptedIssues;
    }
    
    protected function buildAdaptedIssue(Candidate $candidate, Issue $issue)
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
        
        $vote = $this->voteRepository->findOneByCandidateAndIssue($candidate, $issue);
        if ($vote instanceof Vote) {
            $adaptedIssue->setVote($vote);
        }
        
        $view = $this->viewRepository->findOneByIssueAndCandidate($candidate, $issue);
        if ($view instanceof View) {
            $adaptedIssue->setView($view);
        }
        
        return $adaptedIssue;
    }
    
}
