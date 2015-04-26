<?php
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use GuzzleHttp\Client;
use GuzzleHttp\Url;
use TheLgbtWhip\Api\External\CandidateVoteRetrieverInterface;
use TheLgbtWhip\Api\Manager\CandidateIssueManager;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Issue;
use TheLgbtWhip\Api\Model\Vote;
use TheLgbtWhip\Api\Repository\CandidateRepository;
use TheLgbtWhip\Api\Repository\IssueRepository;
use TheLgbtWhip\Api\Repository\VoteRepository;



/**
 * Description of ThePublicWhipPersistingClient
 *
 * @author matt
 */
class ThePublicWhipPersistingClient extends ThePublicWhipClient implements CandidateVoteRetrieverInterface
{
    
    /**
     *
     * @var CandidateRepository
     */
    protected $candidateRepository;
    
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
     * @var CandidateIssueManager
     */
    protected $candidateIssueManager;
    
    
    
    /**
     * 
     * @param Client $httpClient
     * @param Url $baseUrl
     * @param ThePublicWhipPersistingProcessor $processor
     * @param ThePublicWhipScraper $scraper
     * @param CandidateRepository $candidateRepository
     * @param IssueRepository $issueRepository
     * @param VoteRepository $voteRepository
     * @param CandidateIssueManager $candidateIssueManager
     */
    public function __construct(
        Client $httpClient,
        Url $baseUrl,
        ThePublicWhipPersistingProcessor $processor,
        ThePublicWhipScraper $scraper,
        CandidateRepository $candidateRepository,
        IssueRepository $issueRepository,
        VoteRepository $voteRepository,
        CandidateIssueManager $candidateIssueManager
    ) {
        parent::__construct($httpClient, $baseUrl, $processor, $scraper);
        
        $this->candidateRepository = $candidateRepository;
        $this->issueRepository = $issueRepository;
        $this->voteRepository = $voteRepository;
        $this->candidateIssueManager = $candidateIssueManager;
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @return array
     */
    public function getVotesForCandidate(Candidate $candidate)
    {
        $votes = [];
        
        foreach ($this->issueRepository->findAll() as $issue) {
            $this->getVotesForIssue($issue);
            
            $existingVote = $this->voteRepository->findOneByCandidateAndIssue($candidate, $issue);
            
            if ($existingVote instanceof Vote) {
                $votes[] = $existingVote;
            }
        }
        
        return $votes;
    }
    
}
