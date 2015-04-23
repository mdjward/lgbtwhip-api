<?php
/**
 * CandidateNameResolverInterface.php
 * Definition of interface CandidateNameResolverInterface
 * 
 * Created 23-Apr-2015 01:57:26
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External;



/**
 * CandidateNameResolverInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface CandidateNameResolverInterface
{
    
    /**
     * 
     * @param string $candidateName
     * @return Candidate
     */
    public function resolveCandidateByName($candidateName);
    
}
