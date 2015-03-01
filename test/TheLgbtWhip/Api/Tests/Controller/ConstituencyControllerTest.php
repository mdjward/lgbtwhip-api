<?php

namespace TheLgbtWhip\Api\Tests\Controller;

use Phockito;
use PHPUnit_Framework_TestCase as TestCase;
use TheLgbtWhip\Api\Controller\ConstituencyController;
use TheLgbtWhip\Api\Model\View\Constituency;
use TheLgbtWhip\Api\Repository\ConstituencyRepository;
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
    const TEST_ID = 123;

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
     * @var ConstituencyRepository
     */
    private $constituencyRepository;

    /**
     * @var Constituency
     */
    private $constituency;


    /**
     * 
     */
    protected function setUp()
    {
        $this->_mockConstituency();
        $this->client = mock('TheLgbtWhip\Api\External\Client\MapItClient');
        $this->constituencyRepository = mock('TheLgbtWhip\Api\Repository\ConstituencyRepository');
        $this->controller = new ConstituencyController($this->client, $this->constituencyRepository);
    }

    /**
     * @test
     */
    public function testResolveByPostcodeSetsConstituencyName()
    {
        // given
        when($this->client->getConstituencyFromPostcode(self::TEST_POSTCODE))->return(self::TEST_ID);
        when($this->constituencyRepository->find(self::TEST_ID))->return($this->constituency);

        // when
        $result = $this->controller->resolveByPostcodeAction(self::TEST_POSTCODE);

        // then
        $this->assertInstanceOf('TheLgbtWhip\Api\Model\View\Constituency', $result);
        $this->assertEquals(self::TEST_ID, $result->id);
        $this->assertEquals(self::TEST_NAME, $result->name);
    }

    private function _mockConstituency()
    {
        $this->constituency = new Constituency();
        $this->constituency->id = self::TEST_ID;
        $this->constituency->name = self::TEST_NAME;
    }
}
