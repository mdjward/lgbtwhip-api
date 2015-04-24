<?php
/**
 * CandidateAdapterInterface.php
 * Definition of interface CandidateAdapterInterface
 * 
 * Created 24-Apr-2015 09:13:12
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Adapter;

use TheLgbtWhip\Api\Model\Adapted\Candidate as AdapteddCandidate;
use TheLgbtWhip\Api\Model\Candidate;



/**
 * CandidateAdapterInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface CandidateAdapterInterface
{
    
    /**
     * 
     * @param Candidate $candidate
     * @return AdapteddCandidate
     */
    public function adaptCandidate(Candidate $candidate);
    
}
