<?php
/**
 * CandidateNameSearcherInterface.php
 * Definition of interface CandidateNameSearcherInterface
 * 
 * Created 26-Apr-2015 16:20:15
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External;



/**
 * CandidateNameSearcherInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface CandidateNameSearcherInterface
{
    
    /**
     * 
     * @param $name
     * @return string
     */
    public function searchCandidatesByName($name);
    
}
