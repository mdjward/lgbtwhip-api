<?php

namespace TheLgbtWhip\Api\Tests\Controller;

use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use PHPUnit_Framework_TestCase as TestCase;
use Slim\Http\Headers;
use Slim\Http\Response;
use StdClass;
use TheLgbtWhip\Api\Controller\ConstituencyController;
use TheLgbtWhip\Api\External\Client\MapIt\MapItClientInterface;
use TheLgbtWhip\Api\Repository\ConstituencyRepository;



/**
 * 
 * @coversDefaultClass \TheLgbtWhip\Api\Controller\ConstituencyController
 */
class ConstituencyControllerTest extends TestCase
{
    
    /**
     * 
     */
    const TEST_POSTCODE = "TestCode";
    
    /**
     * 
     */
    const TEST_NAME = "Test Name";
    
    /**
     * 
     */
    const TEST_ID = 123;

    
    
    /**
     *
     * @var MapItClientInterface
     */
    private $mapItClient;
    
    /**
     * @var ConstituencyRepository
     */
    private $constituencyRepository;
    
    /**
     *
     * @var Serializer
     */
    private $serializer;

    /**
     * @var ConstituencyController 
     */
    private $controller;

    /**
     * @var Response
     */
    private $response;
    

    
    /**
     * 
     */
    protected function setUp()
    {
        $this->mapItClient = mock(MapItClientInterface::class);
        $this->constituencyRepository = mock(ConstituencyRepository::class);
        $this->serializer = mock(SerializerInterface::class);
        
        $this->controller = new ConstituencyController(
            $this->mapItClient,
            $this->constituencyRepository,
            $this->serializer
        );
        
        $this->response = mock(Response::class);
        $this->response->headers = mock(Headers::class);
        
        $this->controller->setResponse($this->response);
    }
    
    /**
     * @test
     * @covers ::__construct
     * @covers ::resolveByPostcodeAction
     */
    public function testResolveByPostcodeAction()
    {
        $postcode = 'AA1 1AA';
        $mapItResponse = new StdClass();
        $serializedContent = 'Arbitrary, notionally-serialized data';
        
        when($this->response->headers->set(identicalTo('Content-Type'), identicalTo('application/json')))->return(true);
        
        when($this->mapItClient->getConstituencyFromPostcode(identicalTo($postcode)))->return($mapItResponse);
        when($this->serializer->serialize(identicalTo($mapItResponse), identicalTo('json')))->return($serializedContent);
        when($this->response->setBody(identicalTo($serializedContent)))->return(null);
        
        $this->assertNull($this->controller->resolveByPostcodeAction($postcode));
        
        verify($this->response->headers, 1)->set(identicalTo('Content-Type'), identicalTo('application/json'));
        
        verify($this->mapItClient, 1)->getConstituencyFromPostcode(identicalTo($postcode));
        verify($this->serializer, 1)->serialize(identicalTo($mapItResponse), identicalTo('json'));
        verify($this->response, 1)->setBody(identicalTo($serializedContent));
    }

}
