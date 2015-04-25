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
use TheLgbtWhip\Api\External\CandidateVoteRetrieverInterface;
use TheLgbtWhip\Api\External\Client\YourNextMp\YourNextMpProcessor;
use TheLgbtWhip\Api\External\PastMpTermRetrieverInterface;
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
     * @param PastMpTermRetrieverInterface $pastMpTermRetriever
     * @param CandidateVoteRetrieverInterface $candidateVoteRetriever
     * @param integer $targetElectionYear
     */
    public function __construct(
        CandidateAndPartyManager $candidateAndPartyManager,
        ConstituencyManager $constituencyManager,
        PastMpTermRetrieverInterface $pastMpTermRetriever,
        CandidateVoteRetrieverInterface $candidateVoteRetriever,
        $targetElectionYear
    ) {
        parent::__construct(
            $pastMpTermRetriever,
            $candidateVoteRetriever,
            $targetElectionYear
        );
        
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
    
    /**
     * 
     * @param ResponseInterface $response
     * @param array $constituencyData
     * @return Constituency
     */
    protected function buildConstituency(
        ResponseInterface $response,
        array $constituencyData
    ) {
        return $this->constituencyManager->saveConstituency(
            parent::buildConstituency($response, $constituencyData)
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
        return $this->constituencyManager->saveConstituency(
            parent::buildConstituencyFromCandidateSearch(
                $response,
                $constituencyData
            )
        );
    }
    
    protected function augmentCandidateWithVotes(Candidate $candidate)
    {
        /*
         * The candidate may already have been augmented with votes; so if they
         * previously served as an MP
         */
        if (
            $candidate->getTermsAsMp()->count() > 0
            && $candidate->getVotes()->count() > 0
        ) {
            return $candidate;
        }
        
        return parent::augmentCandidateWithVotes($candidate);
    }
    
}
