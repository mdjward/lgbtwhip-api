<?php
/**
 * TheyWorkForYouClient.php
 * Definition of class TheyWorkForYouClient
 * 
 * Created 23-Apr-2015 18:57:00
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client\TheyWorkForYou;

use GuzzleHttp\Client;
use GuzzleHttp\Query;
use TheLgbtWhip\Api\External\CandidateIssueVoteCheckerInterface;
use TheLgbtWhip\Api\External\Client\AbstractRestServiceClient;
use TheLgbtWhip\Api\External\PastMpTermRetrieverInterface;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Model\Issue;



/**
 * TheyWorkForYouClient
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class TheyWorkForYouClient
    extends AbstractRestServiceClient
    implements
        PastMpTermRetrieverInterface,
        CandidateIssueVoteCheckerInterface
{
    
    /**
     *
     * @var TheyWorkForYouProcessorInterface
     */
    protected $processor;
    
    /**
     *
     * @var string
     */
    protected $apiKey;
    
    
    
    /**
     * 
     * @param Client $httpClient
     * @param TheyWorkForYouProcessorInterface $processor
     * @param string $apiKey
     */
    public function __construct(
        Client $httpClient,
        TheyWorkForYouProcessorInterface $processor,
        $apiKey
    ) {
        parent::__construct($httpClient);
        
        $this->processor = $processor;
        $this->apiKey = $apiKey;
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @param Issue $issue
     * @return boolean
     */
    public function checkCandidateCouldHaveVoted(
        Candidate $candidate,
        Issue $issue
    ) {
        $request = $this->httpClient->createRequest('GET', 'getMps');
        
        $query = $this->setQueryDefaults($request->getQuery());
        $query->set('date', $issue->getPublicWhipDate()->format('Y-m-d'));
        
        return $this->processor->checkCandidateWasMpOnDate(
            $candidate,
            $this->httpClient->send($request)->json()
        );
    }
    
    public function findPastTermsForCandidate(Candidate $candidate)
    {
        if (!(($constituency = $candidate->getConstituency())) instanceof Constituency) {
            throw new MissingConstituencyException('Unable to derive constituency from candidate');
        }
        
        $request = $this->httpClient->createRequest('GET', 'getMp');
        
        $query = $this->setQueryDefaults($request->getQuery());
        $query->set('constituency', $constituency->getName());
        
        return $this->httpClient->send($request)->json();
    }
    
    /**
     * 
     * @param Query $query
     * @return Query
     */
    protected function setQueryDefaults(Query $query)
    {
        $query->set('key', $this->apiKey);
        $query->set('always_return', 'true');
        $query->set('output', 'js');
        
        return $query;
    }
    
}
