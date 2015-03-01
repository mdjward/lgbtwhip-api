<?php

namespace TheLgbtWhip\Api\Tests\Controller;

use Phockito;
use PHPUnit_Framework_TestCase as TestCase;
use TheLgbtWhip\Api\Controller\ConstituencyController;
use TheLgbtWhip\Api\External\Client\MapItClient;



/**
 * 
 */
class ConstituencyControllerTest extends TestCase
{
    
    /**
     * 
     */
    const TEST_POSTCODE = "TestCode";
    
    /**
     *
     * @var MapItClient 
     */
    private $client;
    
    /**
     *
     * @var ConstituencyController 
     */
    private $controller;
    
    
    
    /**
     * 
     */
    protected function setUp()
    {
        $this->client = Phockito::mock('TheLgbtWhip\Api\External\Client\MapItClient');
        $this->controller = new ConstituencyController($this->client);
    }
    
    /**
     * @test
     */
    public function testResolvePostcodeReturnsThePostcode()
    {
        // when
        $result = $this->controller->resolveByPostcodeAction(self::TEST_POSTCODE);

        // then
        $this->assertSame(self::TEST_POSTCODE, $result);
    }
}
