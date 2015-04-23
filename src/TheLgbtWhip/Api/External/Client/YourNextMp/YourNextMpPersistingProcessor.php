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
use TheLgbtWhip\Api\Manager\ConstituencyManager;
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
     * @var ConstituencyManager 
     */
    protected $constituencyManager;
    
    
    
    /**
     * 
     * @param CandidateAndPartyManager $candidateAndPartyManager
     * @param ConstituencyManager $constituencyManager
     * @param integer $targetElectionYear
     */
    public function __construct(
        CandidateAndPartyManager $candidateAndPartyManager,
        ConstituencyManager $constituencyManager,
        $targetElectionYear
    ) {
        parent::__construct($targetElectionYear);
        
        $this->candidateAndPartyManager = $candidateAndPartyManager;
        $this->constituencyManager = $constituencyManager;
    }
    
    /**
     * 
     * @param ResponseInterface $response
     * @param array $membershipData
     * @param Constituency $constituency
     * @return Constituency
     */
    protected function buildCandidate(
        ResponseInterface $response,
        array $membershipData,
        Constituency $constituency = null
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
    
    protected function buildConstituency(
        ResponseInterface $response,
        array $constituencyData
    ) {
        return $this->constituencyManager->saveConstituency(
            parent::buildConstituency($response, $constituencyData)
        );
    }
    
}
