<?php
/**
 * CachingHttpClient.php
 * Definition of class CachingHttpClient
 * 
 * Created 25-Apr-2015 15:09:23
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Message\RequestInterface;
use TheLgbtWhip\Api\Cache\Cacheable;
use TheLgbtWhip\Api\Cache\CacheableTrait;



/**
 * CachingHttpClient
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CachingHttpClient extends Client implements Cacheable
{
    use CacheableTrait;
    
    
    
    public function send(RequestInterface $request)
    {
        if ($this->cache === null || strtoupper($request->getMethod()) !== 'GET') {
            return parent::send($request);
        }

        $cacheKey = (string) $request->getUrl();

        if ($this->cache->contains($cacheKey)) {
            return $this->cache->fetch($cacheKey);
        }

        $response = parent::send($request);
        $response->setBody(
            new CachedResponseStream((string) $response->getBody())
        );

        $this->cache->save($cacheKey, $response);

        return $response;
    }
    
}
