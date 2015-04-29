<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TheLgbtWhip\Api\External\Client\YourNextMp;

use DateTime;
use GuzzleHttp\Message\ResponseInterface;
use TheLgbtWhip\Api\External\CandidateVoteRetrieverInterface;
use TheLgbtWhip\Api\External\PastMpTermRetrieverInterface;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Model\Issue;
use TheLgbtWhip\Api\Model\Party;
use TheLgbtWhip\Api\Model\Term;
use TheLgbtWhip\Api\Model\View;
use TheLgbtWhip\Api\Model\Vote;

/**
 * Description of YourNextMpProcessor
 *
 * @author matt
 */
class YourNextMpProcessor implements YourNextMpProcessorInterface
{
    
    /**
     *
     * @var integer
     */
    protected $targetElectionYear;
    
    
    
    /**
     * 
     * @param integer $targetElectionYear
     */
    public function __construct($targetElectionYear)
    {
        $this->targetElectionYear = $targetElectionYear;
    }
    
    /**
     * 
     * @param Constituency $constituency
     * @param ResponseInterface $response
     * @return array
     * @throws YourNextMpException
     */
    public function processCandidates(Constituency $constituency, ResponseInterface $response)
    {
        $responseData = $response->json();
        
        if (!isset($responseData['result']['memberships'])) {
            throw new YourNextMpException(
                sprintf('No candidate data for constituency %s', $constituency->getName())
            );
        }
        
        $candidates = [];
        
        foreach ($responseData['result']['memberships'] as $membershipData) {
            try {
                $candidate = $this->buildCandidate(
                    $response,
                    $membershipData['person_id'],
                    $constituency
                );
                
                $candidates[$candidate->getId()] = $candidate;
            } catch (YourNextMpException $ex) {
                continue;
            }
        }
        
        if (!isset($membershipData['person_id'])) {
            throw new YourNextMpException(
                $response,
                'Missing person details for candidate'
            );
        }
        
        return $candidates;
    }
    
    /**
     * 
     * @param ResponseInterface $response
     * @return Candidate
     */
    public function processCandidateSearchResults(ResponseInterface $response)
    {
        $responseData = $response->json();
        
        if (!isset($responseData['result'][0])) {
            throw new YourNextMpException(
                $response,
                'No candidate was found with given attribute(s)'
            );
        }
        
        $candidateData = $responseData['result'][0];
        
        if (!isset($candidateData['standing_in'][$this->targetElectionYear])) {
            throw new YourNextMpException(
                $response,
                sprintf(
                    'Target constituency could not be matched for candidate for %s',
                    $this->targetElectionYear
                )
            );
        }
        
        return $this->buildCandidate(
            $response,
            $candidateData,
            $this->buildConstituencyFromCandidateSearch(
                $response,
                $candidateData['standing_in'][$this->targetElectionYear]
            )
        );
    }
    
    public function processAllConstituencyResults(ResponseInterface $response)
    {
        $responseData = $response->json();
        
        if (!isset($responseData['result']) || !is_array($responseData['result'])) {
            throw new YourNextMpException(
                $response,
                'No result data available'
            );
        }
        
        $constituencies = [];
        
        foreach ($responseData['result'] as $constituencyData) {
            $constituencies[] = $this->buildConstituency(
                $response,
                $constituencyData
            );
        }
        
        return $constituencies;
    }
    
    /**
     * 
     * @param ResponseInterface $response
     * @return Constituency
     */
    public function processConstituencySearchResults(ResponseInterface $response)
    {
        $responseData = $response->json();
        
        if (!isset($responseData['result'][0])) {
            throw new YourNextMpException(
                $response,
                'No constituency was found with given attribute(s)'
            );
        }
        
        return $this->buildConstituency(
            $response,
            $responseData['result'][0]
        );
    }
    
    protected function buildCandidate(
        ResponseInterface $response,
        array $personData,
        Constituency $constituency
    ) {
        if (!isset($personData['id'])) {
            throw new YourNextMpException(
                $response,
                'Missing person details for candidate'
            );
        }
        
        if (!isset($personData['standing_in'][$this->targetElectionYear]['post_id'])) {
            throw new YourNextMpException(
                $response,
                'Person is not a candidate in the target election'
            );
        }
        
        if ($personData['standing_in'][$this->targetElectionYear]['post_id'] !== $constituency->getId()) {
            throw new YourNextMpException(
                $response,
                'Person is not standing for this constituency in the target election'
            );
        }
        
        $candidate = new Candidate();
        $candidate->setConstituency($constituency);
        
        if (isset($personData['id'])) {
            $candidate->setId($personData['id']);
        }
        
        if (isset($personData['name'])) {
            $candidate->setName($personData['name']);
        }
        
        if (isset($personData['email'])) {
            $candidate->setEmail($personData['email']);
        }
        
        if (isset($personData['party_memberships'][$this->targetElectionYear])) {
            $candidate->setParty(
                $this->buildParty(
                    $response,
                    $personData['party_memberships'][$this->targetElectionYear]
                )
            );
        }
        
        if (isset($personData['links']) && !empty($personData['links'])) {
            foreach ($personData['links'] as $link) {
                switch (strtolower($link['note'])) {
                    case 'homepage':
                        $candidate->setWebsite($link['url']);
                        break;
                    case 'wikipedia':
                        $candidate->setWikipedia($link['url']);
                        break;
                }
            }
        }
        
        if (isset($personData['contact_details']) && !empty($personData['contact_details'])) {
            foreach ($personData['contact_details'] as $contactDetails) {
                switch (strtolower($contactDetails['type'])) {
                    case 'twitter':
                        $candidate->setTwitter($contactDetails['value']);
                        break;
                }
            }
        }
        
        return $candidate;
    }
    
    protected function buildParty(
        ResponseInterface $response,
        array $partyData
    ) {
        $party = new Party();
        
        $matches = [];
        if (preg_match('#^(?:joint-)?party:(?:[0-9]+-)*([0-9]+)?$#', $partyData['id'], $matches)) {
            $party->setId($matches[1]);
        } else {
            $party->setId(0);
        }
        
        $party->setName($partyData['name']);
        
        return $party;
    }
    
    /**
     * 
     * @param ResponseInterface $response
     * @param array $constituencyData
     * @return Constituency
     * @throws YourNextMpException
     */
    protected function buildConstituency(
        ResponseInterface $response,
        array $constituencyData
    ) {
        $constituency = new Constituency();
        
        if (!isset($constituencyData['area']['name'])) {
            throw new YourNextMpException(
                $response,
                'Area data not available for constituency'
            );
        }
        
        $areaData = $constituencyData['area'];
        $constituency->setName($areaData['name']);
        
        $matches = [];
        if (isset($areaData['id']) && preg_match('#mapit:([0-9]+)$#', $areaData['id'], $matches)) {
            return $constituency->setId($matches[1]);
        }
        
        throw new YourNextMpException(
            $response,
            'Insufficient area data for constituency'
        );
    }
    
    /**
     * 
     * @param ResponseInterface $response
     * @param array $constituencyData
     * @return Constituency
     */
    protected function buildConstituencyFromCandidateSearch(
        ResponseInterface $response,
        array $constituencyData
    ) {
        $constituency = new Constituency();
        
        return $constituency
            ->setName($constituencyData['name'])
            ->setId($constituencyData['post_id'])
        ;
    }
    
}
