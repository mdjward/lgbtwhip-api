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
    const TEST_NAME = "Test Name";

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
    public function testResolvePostcodeReturnsConstituency()
    {
        // when
        $result = $this->controller->resolveByPostcodeAction(self::TEST_POSTCODE);

        // then
        $this->assertInstanceOf('TheLgbtWhip\Api\Model\View\Constituency', $result);
    }

    /**
     * @test
     */
    public function testResolveByPostcodeGetsNameFromMapit()
    {
        // given
        Phockito::when($this->client->getConstituencyFromPostcode(self::TEST_POSTCODE))->return(self::TEST_NAME);

        // when
        $result = $this->controller->resolveByPostcodeAction(self::TEST_POSTCODE);

        // then
        $this->assertEquals(self::TEST_NAME, $result->name);
    }
}
