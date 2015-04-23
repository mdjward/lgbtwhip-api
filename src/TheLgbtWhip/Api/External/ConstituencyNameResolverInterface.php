<?php
/**
 * ConstituencyNameResolverInterface.php
 * Definition of interface ConstituencyNameResolverInterface
 * 
 * Created 23-Apr-2015 02:02:44
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External;



/**
 * ConstituencyNameResolverInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface ConstituencyNameResolverInterface
{
    
    /**
     * 
     * @param string $constituencyName
     * @return Constituency
     */
    public function resolveConstituencyByName($constituencyName);
    
}
