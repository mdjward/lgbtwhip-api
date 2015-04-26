<?php
/**
 * PastMpSearchInterface.php
 * Definition of interface PastMpSearchInterface
 * 
 * Created 26-Apr-2015 18:22:51
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client\TheyWorkForYou;

use TheLgbtWhip\Api\Model\Candidate;



/**
 * PastMpSearchInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface PastMpSearchInterface
{
    
    /**
     * 
     * @param \TheLgbtWhip\Api\External\Client\TheyWorkForYou\Candidate $candidate
     * @return integer
     */
    public function findPastMpId(Candidate $candidate);
    
}
