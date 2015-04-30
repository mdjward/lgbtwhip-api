<?php

namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use GuzzleHttp\Client;
use GuzzleHttp\Url;
use TheLgbtWhip\Api\External\CandidateVoteRetrieverInterface;
use TheLgbtWhip\Api\External\Client\AbstractRestServiceClient;
use TheLgbtWhip\Api\External\Client\ThePublicWhip\ThePublicWhipProcessorInterface;
use TheLgbtWhip\Api\External\Client\ThePublicWhip\ThePublicWhipScraper;
use TheLgbtWhip\Api\External\VoteRetrieverInterface;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Issue;

/**
 * Description of ThePublicWhipClient
 *
 * @author matt
 */
class ThePublicWhipClient
    extends AbstractRestServiceClient
    implements VoteRetrieverInterface, CandidateVoteRetrieverInterface
{
    
    /**
     *
     * @var Url
     */
    protected $baseUrl;
    
    /**
     * 
     * @var ThePublicWhipProcessorInterface
     */
    protected $processor;
    
    /**
     *
     * @var ThePublicWhipScraper
     */
    protected $scraper;
    
    
    
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
        ThePublicWhipScraper $scraper
    ) {
        parent::__construct($httpClient);
        
        $this->baseUrl = $baseUrl;
        $this->processor = $processor;
        $this->scraper = $scraper;
    }
    
    /**
     * 
     * @param Issue $issue
     * @return array
     */
    public function getVotesForIssue(Issue $issue)
    {
        if (($publicWhipId = $issue->getPublicWhipId()) === null) {
            return [];
        }
        
        $url = clone $this->baseUrl;
        $query = $url->getQuery();
        
        $query->set('display', 'allvotes');
        $query->set("number", $publicWhipId);
        $query->set("date", $issue->getPublicWhipDate()->format('Y-m-d'));
        
        return $this->processor->processVoteData(
            $issue,
            $this->scraper->parse($this->httpClient->get($url)->getBody(true))
        );
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @param Issue $issue
     * @return Vote|null
     */
    public function getVoteForCandidate(Candidate $candidate, Issue $issue)
    {
        return $this->processor->findCandidateInVotes(
            $candidate,
            $this->getVotesForIssue($issue)
        );
    }
    
}
