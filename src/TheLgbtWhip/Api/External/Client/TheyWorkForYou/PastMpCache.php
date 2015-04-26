<?php
/**
 * PastMpCache.php
 * Definition of class PastMpCache
 * 
 * Created 26-Apr-2015 18:30:56
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client\TheyWorkForYou;

use BadMethodCallException;
use DateTime;
use TheLgbtWhip\Api\Cache\Cacheable;
use TheLgbtWhip\Api\Cache\CacheableTrait;
use TheLgbtWhip\Api\Model\Candidate;



/**
 * PastMpCache
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class PastMpCache implements PastMpSearchInterface, Cacheable
{
    use PastParliamentDateAwareTrait, CacheableTrait;
    
    
    
    /**
     * 
     * @return array
     */
    public function getPastParliamentDates()
    {
        return $this->pastParliamentDates;
    }
    
    /**
     * 
     * @param Candidate $candidate
     */
    public function findPastMpId(Candidate $candidate)
    {
        foreach ($this->pastParliamentDates as $startDate) {
            $list = $this->getListOfPastMps($startDate);
            
            if (($personId = $list->findPastMpId($candidate)) !== null) {
                return $personId;
            }
        }
        
        return null;
    }
    
    /**
     * 
     * @param DateTime $parliamentStartDate
     * @return ListOfPastMps|null
     */
    public function getListOfPastMps(DateTime $parliamentStartDate)
    {
        if ($this->containsListOfPastMps($parliamentStartDate)) {
            return $this->cache->fetch($this->buildCacheKey($parliamentStartDate));
        }
        
        return null;
    }
    
    public function containsListOfPastMps(DateTime $parliamentStartDate)
    {
        $cacheKey = $this->buildCacheKey($parliamentStartDate);
        
        return (
            isset($this->pastParliamentDates[$cacheKey])
            && $this->cache->contains($cacheKey)
        );
    }
    
    public function addListOfPastMps(ListOfPastMps $mps)
    {
        $startDate = $mps->getParliamentStartDate();
        $cacheKey = $this->buildCacheKey($startDate);
        
        if (!isset($this->pastParliamentDates[$cacheKey])) {
            throw new BadMethodCallException(
                'Invalid or unregistered cache key ' . $cacheKey
            );
        }
        
        $this->cache->save($cacheKey, $mps);
        
        return $this;
    }
    
    protected function buildCacheKey(DateTime $parliamentStartDate)
    {
        return (int) $parliamentStartDate->format('Y');
    }
}
