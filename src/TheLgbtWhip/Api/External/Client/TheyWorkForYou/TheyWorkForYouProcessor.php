<?php
/**
 * TheyWorkForYouProcessor.php
 * Definition of class TheyWorkForYouProcessor
 * 
 * Created 26-Apr-2015 00:26:23
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client\TheyWorkForYou;

use DateTime;
use GuzzleHttp\Message\ResponseInterface;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Term;



/**
 * TheyWorkForYouProcessor
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class TheyWorkForYouProcessor implements TheyWorkForYouProcessorInterface
{
    
    public function processListOfPastMps(
        ResponseInterface $response,
        DateTime $parliamentStartDate,
        PastMpCache $cache
    ) {
        $responseData = $response->json();
        
        $listOfMps = new ListOfPastMps($parliamentStartDate);
        
        foreach ($responseData as $mp) {
            $listOfMps->addMpDetails($mp);
        }
        
        $cache->addListOfPastMps($listOfMps);
        
        return $listOfMps;
    }
    
    public function processMpHistory(
        Candidate $candidate,
        ResponseInterface $response
    ) {
        $responseData = $response->json();
        
        $termsAsMp = [];
        
        foreach ($responseData as $response) {
            $term = new Term();
            
            $term
                ->setCandidate($candidate)
                ->setStartDate(
                    DateTime::createFromFormat('Y-m-d', $response['entered_house'])
                )
                ->setEndDate(
                    DateTime::createFromFormat('Y-m-d', $response['left_house'])
                )
            ;
            
            $termsAsMp[] = $term;
        }
        
        return $termsAsMp;
    }
    
    public function checkCandidateWasMpOnDate(
        Candidate $candidate,
        ResponseInterface $response
    ) {
        $constituency = $candidate->getConstituency();
        
        $candidateName = $candidate->getName();
        $constituencyName = $constituency->getName();
        
        foreach ($response->json() as $mpData) {
            $mpName = $mpData['name'];
            $mpConstituency = $mpData['constituency'];
            
            if ($mpName === $candidateName && $mpConstituency === $constituencyName) {
                return true;
            }
        }
        
        return false;
    }
    
}
