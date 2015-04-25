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
use TheLgbtWhip\Api\External\Client\AbstractRestServiceClient;
use TheLgbtWhip\Api\External\PastMpTermRetrieverInterface;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;



/**
 * TheyWorkForYouClient
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class TheyWorkForYouClient extends AbstractRestServiceClient implements PastMpTermRetrieverInterface
{
    
    /**
     *
     * @var string
     */
    protected $apiKey;
    
    
    
    /**
     * 
     * @param Client $httpClient
     * @param string $apiKey
     */
    public function __construct(
        Client $httpClient,
        $apiKey
    ) {
        parent::__construct($httpClient);
        
        $this->apiKey = $apiKey;
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
    
    public function findMps(DateTime $date)
    {
        $request = $this->httpClient->createRequest('GET', 'getMps');
        
        $query = $this->setQueryDefaults($request->getQuery());
        $query->set('date', $date->format('Y-m-d'));
        
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
