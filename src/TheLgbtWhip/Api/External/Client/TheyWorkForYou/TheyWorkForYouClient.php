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

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Query;
use TheLgbtWhip\Api\External\CandidateIssueVoteCheckerInterface;
use TheLgbtWhip\Api\External\Client\AbstractRestServiceClient;
use TheLgbtWhip\Api\External\PastMpTermRetrieverInterface;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Issue;



/**
 * TheyWorkForYouClient
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class TheyWorkForYouClient
    extends AbstractRestServiceClient
    implements PastMpTermRetrieverInterface, CandidateIssueVoteCheckerInterface
{
    
    /**
     *
     * @var TheyWorkForYouProcessorInterface
     */
    protected $processor;
    
    /**
     *
     * @var PastMpCache
     */
    protected $pastMpCache;
    
    /**
     *
     * @var string
     */
    protected $apiKey;
    
    
    
    /**
     * 
     * @param Client $httpClient
     * @param TheyWorkForYouProcessorInterface $processor
     * @param PastMpCache $pastMpCache
     * @param type $apiKey
     */
    public function __construct(
        Client $httpClient,
        TheyWorkForYouProcessorInterface $processor,
        PastMpCache $pastMpCache,
        $apiKey
    ) {
        parent::__construct($httpClient);
        
        $this->processor = $processor;
        $this->pastMpCache = $pastMpCache;
        $this->apiKey = $apiKey;
    }
    
    /**
     * 
     * @param DateTime $parliamentStartDate
     * @return ListOfPastMps
     */
    public function getListOfPastMps(DateTime $parliamentStartDate)
    {
        if ($this->pastMpCache->containsListOfPastMps($parliamentStartDate)) {
            return $this->pastMpCache->getListOfPastMps($parliamentStartDate);
        }
        
        $request = $this->httpClient->createRequest('GET', 'getMPs');
        
        $query = $this->setQueryDefaults($request->getQuery());
        $query->set('date', $parliamentStartDate->format('Y-m-d'));
        
        return $this->processor->processListOfPastMps(
            $this->httpClient->send($request),
            $parliamentStartDate,
            $this->pastMpCache
        );
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
        
        if (!(($voteDate = $issue->getPublicWhipDate()) instanceof DateTime)) {
            return false;
        }
        
        $query = $this->setQueryDefaults($request->getQuery());
        $query->set('date', $voteDate->format('Y-m-d'));
        
        return $this->processor->checkCandidateWasMpOnDate(
            $candidate,
            $this->httpClient->send($request)
        );
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @return Candidate
     * @throws MissingConstituencyException
     */
    public function findPastTermsForCandidate(Candidate $candidate)
    {
        $personId = $this->pastMpCache->findPastMpId($candidate);
        
        if ($personId === null) {
            return [];
        }
        
        $request = $this->httpClient->createRequest('GET', 'getMP');
        
        $query = $this->setQueryDefaults($request->getQuery());
        $query->set('id', $personId);
        
        return $this->processor->processMpHistory(
            $candidate,
            $this->httpClient->send($request)
        );
        
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
