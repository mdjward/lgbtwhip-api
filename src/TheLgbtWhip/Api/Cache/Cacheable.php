<?php
/**
 * Cacheable.php
 * Definition of interface Cacheable
 * 
 * Created 21-Apr-2015 19:14:27
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Cache;

use Doctrine\Common\Cache\Cache;



/**
 * Cacheable
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface Cacheable
{
    
    /**
     * 
     * @param Cache $cache
     */
    public function setCache(Cache $cache);
    
}
