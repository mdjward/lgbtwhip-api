<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace TheLgbtWhip\Api\External\Client\YourNextMp;

use GuzzleHttp\Client;
use GuzzleHttp\Message\RequestInterface;
use TheLgbtWhip\Api\External\AllConstituenciesRetrieverInterface;
use TheLgbtWhip\Api\External\CandidateIdResolverInterface;
use TheLgbtWhip\Api\External\CandidateNameResolverInterface;
use TheLgbtWhip\Api\External\CandidateNameSearcherInterface;
use TheLgbtWhip\Api\External\Client\AbstractRestServiceClient;
use TheLgbtWhip\Api\External\ConstituencyCandidatesRetrieverInterface;
use TheLgbtWhip\Api\External\ConstituencyIdResolverInterface;
use TheLgbtWhip\Api\External\ConstituencyNameResolverInterface;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;



/**
 * Description of YourNextMpClient
 *
 * @author matt
 */
class YourNextMpClient
    extends
        AbstractRestServiceClient
    implements
        AllConstituenciesRetrieverInterface,
        ConstituencyCandidatesRetrieverInterface,
        CandidateIdResolverInterface,
        CandidateNameResolverInterface,
        CandidateNameSearcherInterface,
        ConstituencyIdResolverInterface,
        ConstituencyNameResolverInterface
{    
    /**
     *
     * @var YourNextMpProcessorInterface 
     */
    protected $processor;
    
    
    
    /**
     * 
     * @param Client $httpClient
     * @param YourNextMpProcessorInterface $processor
     */
    public function __construct(
        Client $httpClient,
        YourNextMpProcessorInterface $processor
    ) {
        parent::__construct($httpClient);
        
        $this->processor = $processor;
    }
    
    /**
     * 
     * @param Constituency $constituency
     * @return array
     */
    public function getCandidatesForConstituency(Constituency $constituency)
    {
        return $this->processor->processCandidates(
            $constituency,
            $this->httpClient->get(
                sprintf(
                    'posts/%s?embed=membership.person',
                    $constituency->getId()
                )
            )
        );
    }
    
    /**
     * 
     * @param integer $candidateId
     * @return Candidate
     */
    public function resolveCandidateById($candidateId)
    {
        $request = $this->httpClient->createRequest('GET', 'search/persons');
        $request->getQuery()->add('q', 'id:' . $candidateId);
        
        return $this->processor->processCandidateSearchResults(
            $this->httpClient->send($request)
        );
    }
    
    /**
     * 
     * @param string $candidateName
     * @return Candidate
     */
    public function resolveCandidateByName($candidateName)
    {
        $request = $this->httpClient->createRequest('GET', 'search/persons');
        $request->getQuery()->add('q', sprintf('name:"%s"', $candidateName));
        
        return $this->processor->processCandidateSearchResults(
            $this->httpClient->send($request)
        );
    }
    
    /**
     * 
     * @param string $name
     * @return array
     */
    public function searchCandidatesByName($name)
    {
        return [];
    }
    
    /**
     * 
     * @param RequestInterface $request
     * @return Candidate
     */
    protected function resolveCandidate(RequestInterface $request)
    {
        return $this->processor->processCandidateSearchResults(
            $this->httpClient->send($request)
        );
    }
    
    /**
     * 
     * @return array
     */
    public function getAllConstituencies()
    {
        $constituencies = [];
        
        $currentPage = 0;
        $hasMore = true;
        
        do {
            $currentPage++;
            
            $request = $this->httpClient->createRequest('GET', 'posts');
            $request->getQuery()->set('page', $currentPage);

            $response = $this->httpClient->send($request);
            $responseData = $response->json();
            
            $constituencies = array_merge(
                $constituencies,
                $this->processor->processAllConstituencyResults($response)
            );
            
            $hasMore = (isset($responseData['has_more']) ? $responseData['has_more'] : false);
            
        } while ($hasMore === true);
        
        return $constituencies;
    }
    
    /**
     * 
     * @param integer $constituencyId
     * @return Constituency
     */
    public function resolveConstituencyById($constituencyId)
    {
        $request = $this->httpClient->createRequest('GET', 'search/posts');
        $request->getQuery()->add('q', 'id:' . $constituencyId);
        
        return $this->resolveConstituency($request);
    }
    
    /**
     * 
     * @param string $constituencyName
     * @return Constituency
     */
    public function resolveConstituencyByName($constituencyName)
    {
        $request = $this->httpClient->createRequest('GET', 'search/posts');
        $request->getQuery()->add('q', sprintf('name:"%s"', $constituencyName));
        
        return $this->resolveConstituency($request);
    }
    
    /**
     * 
     * @param RequestInterface $request
     * @return Constituency
     */
    protected function resolveConstituency(RequestInterface $request)
    {
        return $this->processor->processConstituencySearchResults(
            $this->httpClient->send($request)
        );
    }
    
}
