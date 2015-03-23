<?php
/**
 * AbstractControllerTest.php
 * Definition of class AbstractControllerTest
 * 
 * Created 23-Mar-2015 07:28:46
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Tests\Controller;

use Phockito;
use PHPUnit_Framework_TestCase as TestCase;
use Slim\Environment;
use Slim\Http\Request;
use Slim\Http\Response;
use TheLgbtWhip\Api\Controller\AbstractController;



/**
 * AbstractControllerTest
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @coversDefaultClass \TheLgbtWhip\Api\Controller\AbstractController
 */
class AbstractControllerTest extends TestCase
{
    
    /**
     *
     * @var Request
     */
    private $request;
    
    /**
     *
     * @var Response
     */
    private $response;
    
    /**
     *
     * @var Environment
     */
    private $environment;
    
    /**
     *
     * @var AbstractController
     */
    private $controller;
    
    
    
    /**
     * 
     */
    protected function setUp()
    {
        $this->request = mock(Request::class);
        $this->response = mock(Response::class);
        $this->environment = mock(Environment::class);
        
        $this->controller = $this->getMockForAbstractClass(AbstractController::class);
    }
    
    /**
     * @test
     * @covers ::getRequest
     * @covers ::setRequest
     * @covers ::getResponse
     * @covers ::setResponse
     * @covers ::getEnvironment
     * @covers ::setEnvironment
     */
    public function testGettersAndSetters()
    {
        $this->assertNull($this->controller->getRequest());
        $this->assertNull($this->controller->getResponse());
        $this->assertNull($this->controller->getEnvironment());
        
        $this->assertSame(
            $this->controller,
            $this->controller->setRequest($this->request)
        );
        $this->assertSame(
            $this->controller,
            $this->controller->setResponse($this->response)
        );
        $this->assertSame(
            $this->controller,
            $this->controller->setEnvironment($this->environment)
        );
        
        $this->assertSame($this->request, $this->controller->getRequest());
        $this->assertSame($this->response, $this->controller->getResponse());
        $this->assertSame($this->environment, $this->controller->getEnvironment());
    }
    
}
