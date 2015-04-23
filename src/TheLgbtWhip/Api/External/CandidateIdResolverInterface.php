<?php
/**
 * CandidateIdResolverInterface.php
 * Definition of interface CandidateIdResolverInterface
 * 
 * Created 23-Apr-2015 01:57:59
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External;



/**
 * CandidateIdResolverInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface CandidateIdResolverInterface
{
    
    /**
     * 
     * @param string $candidateId
     * @return Candidate
     */
    public function resolveCandidateById($candidateId);
    
}
