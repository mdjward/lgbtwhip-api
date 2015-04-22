<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TheLgbtWhip\Api\External\Client\YourNextMp;

use GuzzleHttp\Message\ResponseInterface;
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
    public function __construct($targetElectionYear)
    {
        $this->targetElectionYear = $targetElectionYear;
    }
    
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
                    $membershipData,
                    $constituency
                );
                $candidates[$candidate->getId()] = $candidate;
            } catch (YourNextMpException $ex) {
                continue;
            }
        }
        
        return $candidates;
    }
    
    /**
     * 
     * @param ResponseInterface $response
     * @param array $membershipData
     * @param Constituency $constituency
     * @return Candidate
     * @throws YourNextMpException
     */
    protected function buildCandidate(
        ResponseInterface $response,
        array $membershipData,
        Constituency $constituency
    ) {
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
    
}
