<?php
/**
 * ConstituencyIdResolverInterface.php
 * Definition of interface ConstituencyIdResolverInterface
 * 
 * Created 23-Apr-2015 02:02:11
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External;



/**
 * ConstituencyIdResolverInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface ConstituencyIdResolverInterface
{
    
    /**
     * 
     * @param integer $constituencyId
     */
    public function resolveConstituencyById($constituencyId);
    
}
