<?php
/**
 * CacheableCompilerPass.php
 * Definition of class CacheableCompilerPass
 * 
 * Created 21-Apr-2015 19:15:27
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use TheLgbtWhip\Api\Cache\CacheServiceFactory;



/**
 * CacheableCompilerPass
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CacheableCompilerPass implements CompilerPassInterface
{

    /**
     *
     * @var CacheServiceFactory
     */
    protected $cacheServiceFactory;
    
    /**
     *
     * @var string
     */
    protected $tagName;
    
    
    
    /**
     * 
     * @param CacheServiceFactory $cacheFactory
     * @param string $tagName
     */
    public function __construct(
        CacheServiceFactory $cacheFactory,
        $tagName = 'cacheable'
    ) {
        $this->cacheFactory = $cacheFactory;
        $this->tagName = $tagName;
    }
    
    public function process(ContainerBuilder $container)
    {
        $tagged = $container->findTaggedServiceIds($this->tagName);
        
        foreach ($tagged as $serviceId => $instances) {
            $this->processTag($container, $instances, $serviceId);
        }
    }
    
    protected function processTag(
        ContainerBuilder $container,
        array $instances,
        $serviceId
    ) {
        foreach ($instances as $attributes) {
            $service = $container->findDefinition($serviceId);
            
            $service->addMethodCall(
                'setCache',
                [
                    $this->cacheFactory->buildCache(
                        array_merge(['namespace' => $serviceId], $attributes)
                    )
                ]
            );
        }
    }
    
}
