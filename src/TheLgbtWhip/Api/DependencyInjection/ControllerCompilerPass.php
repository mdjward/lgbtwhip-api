<?php
/**
 * ControllerCompilerPass.php
 * Definition of class ControllerCompilerPass
 * 
 * Created 01-Mar-2015 19:13:49
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */

namespace TheLgbtWhip\Api\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;



/**
 * ControllerCompilerPass
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ControllerCompilerPass implements CompilerPassInterface
{
    
    /**
     *
     * @var string
     */
    protected $tagName;
    
    /**
     *
     * @var string
     */
    protected $requestServiceId;
    
    /**
     *
     * @var string 
     */
    protected $responseServiceId;
    
    /**
     *
     * @var string
     */
    protected $envServiceId;
    
    
    
    /**
     * 
     * @param string $tagName
     * @param string $requestServiceId
     * @param string $responseServiceId
     * @param string $envServiceId
     */
    public function __construct(
        $tagName = 'controller',
        $requestServiceId = 'request',
        $responseServiceId = 'response',
        $envServiceId = 'environment'
    ) {
        $this
            ->setTagName($tagName)
            ->setRequestServiceId($requestServiceId)
            ->setResponseServiceId($responseServiceId)
            ->setEnvServiceId($envServiceId)
        ;
    }
    
    /**
     * 
     * @return string
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    /**
     * 
     * @return string
     */
    public function getRequestServiceId()
    {
        return $this->requestServiceId;
    }

    /**
     * 
     * @return string
     */
    public function getResponseServiceId()
    {
        return $this->responseServiceId;
    }

    /**
     * 
     * @return string
     */
    public function getEnvServiceId()
    {
        return $this->envServiceId;
    }
    
    /**
     * 
     * @param string $tagName
     * @return ControllerCompilerPass
     */
    public function setTagName($tagName)
    {
        $this->tagName = $tagName;
        
        return $this;
    }

    /**
     * 
     * @param type $requestServiceId
     * @return ControllerCompilerPass
     */
    public function setRequestServiceId($requestServiceId)
    {
        $this->requestServiceId = $requestServiceId;
        
        return $this;
    }

    /**
     * 
     * @param string $responseServiceId
     * @return ControllerCompilerPass
     */
    public function setResponseServiceId($responseServiceId)
    {
        $this->responseServiceId = $responseServiceId;
        
        return $this;
    }

    /**
     * 
     * @param string $envServiceId
     * @return ControllerCompilerPass
     */
    public function setEnvServiceId($envServiceId)
    {
        $this->envServiceId = $envServiceId;
        
        return $this;
    }

    /**
     * 
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        foreach (array_keys($container->findTaggedServiceIds($this->tagName)) as $taggedServiceId) {
            $definition = $container->getDefinition($taggedServiceId);
            
            $definition->addMethodCall(
                'setRequest',
                [new Reference($this->requestServiceId)]
            );
            
            $definition->addMethodCall(
                'setResponse',
                [new Reference($this->responseServiceId)]
            );
            
            $definition->addMethodCall(
                'setEnvironment',
                [new Reference($this->envServiceId)]
            );
        }
    }

}
