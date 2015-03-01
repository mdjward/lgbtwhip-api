<?php

class ConstituencyControllerTest extends PHPUnit_Framework_TestCase
{
    const TEST_POSTCODE = "TestCode";

    public function testResolvePostcodeReturnsThePostcode()
    {
        // given
        $mockClient = Phockito::mock('TheLgbtWhip\Api\External\Client\MapItClient');
        $controller = new \TheLgbtWhip\Api\Controller\ConstituencyController($mockClient);

        // when
        $result = $controller->resolveByPostcodeAction(self::TEST_POSTCODE);

        // then
        $this->assertEquals(self::TEST_POSTCODE, $result);
    }
} 