<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TheLgbtWhip\Api\External\Client\YourNextMp;

use GuzzleHttp\Message\Response;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Model\Party;

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
    public function __construct($targetElectionYear = 2015)
    {
        $this->targetElectionYear = $targetElectionYear;
    }
    
    public function processCandidates(Constituency $constituency, Response $response)
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
                $candidate = $this->buildCandidate($response, $membershipData);
                $candidates[$candidate->getId()] = $candidate;
            } catch (YourNextMpException $ex) {
                continue;
            }
        }
        
        return $candidates;
    }
    
    /**
     * 
     * @param Response $response
     * @param array $membershipData
     * @return Candidate
     */
    protected function buildCandidate(Response $response, array $membershipData)
    {
        if (!isset($membershipData['person_id'])) {
            throw new YourNextMpException('Missing person details for candidate');
        }
        
        $personData = $membershipData['person_id'];
        
        if (!isset($personData['standing_in'][$this->targetElectionYear])) {
            throw new YourNextMpException(
                $response,
                'Person is not a candidate in the target election'
            );
        }
        
        $candidate = new Candidate();
        
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
        
        return $candidate;
    }
    
    protected function buildParty(
        Response $response,
        array $partyData
    ) {
        $party = new Party();
        
        $matches = [];
        if (preg_match('#^party:([0-9]+)$#', $partyData['id'], $matches)) {
            $party->setId($matches[1]);
        }
        
        $party->setName($partyData['name']);
        
        return $party;
    }
    
}
