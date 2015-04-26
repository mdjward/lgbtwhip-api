<?php
/**
 * CacheNotInitialisedException.php
 * Definition of class CacheNotInitialisedException
 * 
 * Created 26-Apr-2015 13:39:44
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Cache;

use Exception;



/**
 * CacheNotInitialisedException
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CacheNotInitialisedException extends Exception
{
    
    /**
     * 
     */
    public function __construct()
    {
        parent::__construct('Cache has not been initialised', 0, null);
    }
    
}
