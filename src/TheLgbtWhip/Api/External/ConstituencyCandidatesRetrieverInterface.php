<?php
/**
 * ConstituencyCandidatesRetrieverInterface.php
 * Definition of interface ConstituencyCandidatesRetrieverInterface
 * 
 * Created 21-Apr-2015 19:05:52
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External;

use TheLgbtWhip\Api\Model\Constituency;



/**
 * ConstituencyCandidatesRetrieverInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface ConstituencyCandidatesRetrieverInterface
{
    
    public function getCandidatesForConstituency(Constituency $constituency);
    
}
