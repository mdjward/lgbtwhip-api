<?php
/**
 * PostcodeToConstituencyMappingInterface.php
 * Definition of interface PostcodeToConstituencyMappingInterface
 * 
 * Created 21-Apr-2015 18:55:48
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External;

use TheLgbtWhip\Api\Model\Constituency;



/**
 * PostcodeToConstituencyMappingInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface PostcodeToConstituencyMappingInterface
{
    
    /**
     * 
     * @param string $postcode
     * @return Constituency
     */
    public function getConstituencyFromPostcode($postcode);
    
}
