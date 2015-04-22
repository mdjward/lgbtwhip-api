<?php
/**
 * CacheServiceFactory.php
 * Definition of class CacheServiceFactory
 * 
 * Created 22-Apr-2015 00:20:51
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Cache;

use Doctrine\Common\Cache\FilesystemCache;
use Symfony\Component\DependencyInjection\Definition;



/**
 * CacheServiceFactory
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CacheServiceFactory
{
    
    /**
     * 
     */
    const TYPE_ATTRIBUTE = 'type';
    
    /**
     * 
     */
    const NAMESPACE_ATTRIBUTE = 'namespace';
    
    
    
    /**
     *
     * @var string
     */
    protected $baseFilesystemCachePath;
    
    
    
    /**
     * 
     * @param string $baseFilesystemCachePath
     */
    public function __construct($baseFilesystemCachePath)
    {
        $this->baseFilesystemCachePath = $baseFilesystemCachePath;
    }
    
    /**
     * 
     * @param array $attributes
     * @return Definition
     * @throws CacheBuildingException
     */
    public function buildCache(array $attributes)
    {
        $type = strtolower(
            isset($attributes[self::TYPE_ATTRIBUTE])
            ? $attributes[self::TYPE_ATTRIBUTE]
            : 'filesystem'
        );
        
        switch ($type) {
            case 'filesystem':
                
                if (!isset($attributes[self::NAMESPACE_ATTRIBUTE])) {
                    throw new CacheBuildingException(
                        'Missing namespace for filesystem cache'
                    );
                }
                
                return $this->buildFilesystemCache(
                    isset($attributes['namespace'])
                    ? $attributes['namespace']
                    : null
                );
        }
        
        throw new CacheBuildingException(
            'Unrecognised cache type ' . $type
        );
    }
    
    public function buildFilesystemCache($namespace)
    {
        $cacheDefinition = new Definition(
            'Doctrine\Common\Cache\FilesystemCache'
        );
        
        $cacheDefinition->addArgument(
            $this->baseFilesystemCachePath . '/' . $namespace
        );
        
        $cacheDefinition->addMethodCall(
            'setNamespace',
            [$namespace]
        );

        return $cacheDefinition;
    }
    
}
