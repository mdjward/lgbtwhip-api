<?php
/**
 * CacheableTrait.php
 * Definition of class CacheableTrait
 * 
 * Created 22-Apr-2015 00:11:16
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Cache;

use Doctrine\Common\Cache\Cache;



/**
 * CacheableTrait
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
trait CacheableTrait
{
    
    /**
     *
     * @var Cache
     */
    protected $cache;
    
    /**
     * 
     * @param Cache $cache
     * @return CacheableTrait
     */
    final public function setCache(Cache $cache)
    {
        $this->cache = $cache;
        
        return $this;
    }
    
}
