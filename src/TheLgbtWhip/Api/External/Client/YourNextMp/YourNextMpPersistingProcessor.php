<?php
/**
 * YourNextMpPersistingProcessor.php
 * Definition of class YourNextMpPersistingProcessor
 * 
 * Created 22-Apr-2015 09:27:51
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client\YourNextMp;

use GuzzleHttp\Message\ResponseInterface;
use TheLgbtWhip\Api\Manager\CandidateAndPartyManager;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Model\Party;



/**
 * YourNextMpPersistingProcessor
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class YourNextMpPersistingProcessor extends YourNextMpProcessor
{
    
    /**
     *
     * @var CandidateAndPartyManager
     */
    protected $candidateAndPartyManager;
    
    
    
    /**
     * 
     * @param CandidateAndPartyManager $candidateAndPartyManager
     * @param integer $targetElectionYear
     */
    public function __construct(
        CandidateAndPartyManager $candidateAndPartyManager,
        $targetElectionYear
    ) {
        parent::__construct($targetElectionYear);
        
        $this->candidateAndPartyManager = $candidateAndPartyManager;
    }
    
    /**
     * 
     * @param ResponseInterface $response
     * @param array $membershipData
     * @return Candidate
     */
    protected function buildCandidate(
        ResponseInterface $response,
        array $membershipData,
        Constituency $constituency
    ) {
        return $this->candidateAndPartyManager->saveCandidate(
            parent::buildCandidate($response, $membershipData, $constituency)
        );
    }
    
    /**
     * 
     * @param ResponseInterface $response
     * @param array $partyData
     * @return Party
     */
    protected function buildParty(
        ResponseInterface $response,
        array $partyData
    ) {
        return $this->candidateAndPartyManager->saveParty(
            parent::buildParty($response, $partyData)
        );
    }
    
}
