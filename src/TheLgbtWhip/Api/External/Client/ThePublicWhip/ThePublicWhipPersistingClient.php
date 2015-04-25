<?php
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use GuzzleHttp\Client;
use GuzzleHttp\Url;
use TheLgbtWhip\Api\External\CandidateVoteRetrieverInterface;
use TheLgbtWhip\Api\Model\Candidate;
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
     * @param Client $httpClient
     * @param Url $baseUrl
     * @param ThePublicWhipProcessorInterface $processor
     * @param ThePublicWhipScraper $scraper
     */
    public function __construct(
        Client $httpClient,
        Url $baseUrl,
        ThePublicWhipProcessorInterface $processor,
        ThePublicWhipScraper $scraper,
        CandidateRepository $candidateRepository,
        IssueRepository $issueRepository,
        VoteRepository $voteRepository
    ) {
        parent::__construct($httpClient, $baseUrl, $processor, $scraper);
        
        $this->candidateRepository = $candidateRepository;
        $this->issueRepository = $issueRepository;
        $this->voteRepository = $voteRepository;
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
            $existingVote = $this->voteRepository->findOneByCandidateAndIssue($candidate, $issue);
            
            if ($existingVote instanceof Vote) {
                $votes[] = $existingVote;
            }
        }
        
        return $votes;
    }
    
}
