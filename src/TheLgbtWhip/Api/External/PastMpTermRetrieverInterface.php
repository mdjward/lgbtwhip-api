<?php
/**
 * PastMpTermRetrieverInterface.php
 * Definition of interface PastMpTermRetrieverInterface
 * 
 * Created 23-Apr-2015 18:40:17
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External;

use TheLgbtWhip\Api\Model\Candidate;



/**
 * PastMpTermRetrieverInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface PastMpTermRetrieverInterface
{
    
    /**
     * 
     * @param Candidate $candidate
     * @return array
     */
    public function findPastTermsForCandidate(Candidate $candidate);
    
}
