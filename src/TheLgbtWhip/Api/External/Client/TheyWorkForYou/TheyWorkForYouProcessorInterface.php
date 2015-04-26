<?php
/**
 * TheyWorkForYouProcessorInterface.php
 * Definition of interface TheyWorkForYouProcessorInterface
 * 
 * Created 26-Apr-2015 00:10:57
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client\TheyWorkForYou;

use DateTime;
use GuzzleHttp\Message\ResponseInterface;
use TheLgbtWhip\Api\Model\Candidate;



/**
 * TheyWorkForYouProcessorInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface TheyWorkForYouProcessorInterface
{
    
    public function processListOfPastMps(
        ResponseInterface $response,
        DateTime $parliamentStartDate,
        PastMpCache $cache
    );
    
    public function processMpHistory(
        Candidate $candidate,
        ResponseInterface $response
    );
    
    public function checkCandidateWasMpOnDate(
        Candidate $candidate,
        ResponseInterface $response
    );
    
}
