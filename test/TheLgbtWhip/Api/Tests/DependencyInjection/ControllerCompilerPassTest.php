<?php
namespace TheLgbtWhip\Api\Tests\DependencyInjection;

use Closure;
use Phockito;
use PHPUnit_Framework_TestCase as TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use TheLgbtWhip\Api\DependencyInjection\ControllerCompilerPass;

/**
 * Description of ControllerCompilerPassTest
 *
 * @author matt
 * @coversDefaultClass \TheLgbtWhip\Api\DependencyInjection\ControllerCompilerPass
 */
class ControllerCompilerPassTest extends TestCase
{
    
    /**
     *
     * @var string
     */
    private $tagName = 'TAG NAME';
    
    /**
     *
     * @var string
     */
    private $requestServiceId = 'REQUEST SERVICE ID';
    
    /**
     *
     * @var string
     */
    private $responseServiceId = 'RESPONSE SERVICE ID';
    
    
    /**
     *
     * @var string
     */
    private $envServiceId = 'ENVIRONMENT SERVICE ID';
    
    /**
     *
     * @var ControllerCompilerPass
     */
    private $compilerPass;
    
    /**
     *
     * @var ContainerBuilder
     */
    private $containerBuilder;
    
    
    
    /**
     * 
     */
    protected function setUp()
    {
        $this->compilerPass = new ControllerCompilerPass(
            $this->tagName,
            $this->requestServiceId,
            $this->responseServiceId,
            $this->envServiceId
        );
        
        $this->containerBuilder = Phockito::mock(ContainerBuilder::class);
    }
    
    /**
     * 
     * @test
     * @covers ::__construct
     * @covers ::getTagName
     * @covers ::getRequestServiceId
     * @covers ::getResponseServiceId
     * @covers ::getEnvServiceId
     * @covers ::setTagName
     * @covers ::setRequestServiceId
     * @covers ::setResponseServiceId
     * @covers ::setEnvServiceId
     */
    public function testConstructorGettersAndSetters()
    {
        $this->assertSame($this->tagName, $this->compilerPass->getTagName());
        $this->assertSame($this->requestServiceId, $this->compilerPass->getRequestServiceId());
        $this->assertSame($this->responseServiceId, $this->compilerPass->getResponseServiceId());
        $this->assertSame($this->envServiceId, $this->compilerPass->getEnvServiceId());
        
        $newTagName = 'NEW TAG NAME';
        $newRequestServiceId = 'NEW REQUEST SERVICE ID';
        $newResponseServiceId = 'NEW RESPONSE SERVICE ID';
        $newEnvServiceId = 'NEW ENV SERVICE ID';
        
        $this->assertSame($this->compilerPass, $this->compilerPass->setTagName($newTagName));
        $this->assertSame($this->compilerPass, $this->compilerPass->setRequestServiceId($newRequestServiceId));
        $this->assertSame($this->compilerPass, $this->compilerPass->setResponseServiceId($newResponseServiceId));
        $this->assertSame($this->compilerPass, $this->compilerPass->setEnvServiceId($newEnvServiceId));
        
        $this->assertSame($newTagName, $this->compilerPass->getTagName());
        $this->assertSame($newRequestServiceId, $this->compilerPass->getRequestServiceId());
        $this->assertSame($newResponseServiceId, $this->compilerPass->getResponseServiceId());
        $this->assertSame($newEnvServiceId, $this->compilerPass->getEnvServiceId());
    }
    
    /**
     * @test
     * @covers ::__construct
     * @covers ::process
     */
    public function testProcess()
    {
        $controllerServiceId = 'myControllerServiceId';
        
        $expectedCalls = [
            'setRequest'        =>  'requestServiceId',
            'setResponse'       =>  'responseServiceId',
            'setEnvironment'    =>  'envServiceId'
        ];
        
        /* @var $definition Definition */
        $definition = $this
                ->getMockBuilder(Definition::class)
                ->disableOriginalConstructor()
                ->getMock()
        ;
        
        $i = 0;
        foreach ($expectedCalls as $methodName => $serviceIdProperty) {
            $definition
                ->expects($this->at($i))
                ->method('addMethodCall')
                ->with(
                    $this->identicalTo($methodName),
                    $this->isType('array')
                )
                ->will(
                    $this->returnCallback(
                        Closure::bind(
                            function($methodName, array $arguments) use ($serviceIdProperty) {
                                $this->assertCount(1, $arguments);
                                
                                $this->assertInstanceOf(
                                    Reference::class,
                                    $arguments[0]
                                );
                                
                                $this->assertSame(
                                    $arguments[0]->__toString(),
                                    strtolower($this->$serviceIdProperty)
                                );
                            },
                            $this
                        )
                    )
                )
            ;
            
            $i++;
        }
        
        Phockito
            ::when(
                $this->containerBuilder->findTaggedServiceIds(identicalTo($this->tagName))
            )
            ->return([
                $controllerServiceId => []
            ])
        ;
        
        Phockito::when($this->containerBuilder->getDefinition(identicalTo($controllerServiceId)))
            ->return($definition)
        ;
        
        $this->compilerPass->process($this->containerBuilder);
        
        Phockito::verify($this->containerBuilder, 1)
            ->findTaggedServiceIds(identicalTo($this->tagName))
        ;
        
        Phockito::verify($this->containerBuilder, 1)
            ->getDefinition(identicalTo($controllerServiceId))
        ;
    }
    
}
