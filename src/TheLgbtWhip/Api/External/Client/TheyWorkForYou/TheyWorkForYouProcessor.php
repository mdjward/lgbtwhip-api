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

use GuzzleHttp\Message\ResponseInterface;
use TheLgbtWhip\Api\Model\Candidate;



/**
 * TheyWorkForYouProcessor
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class TheyWorkForYouProcessor implements TheyWorkForYouProcessorInterface
{
    
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
