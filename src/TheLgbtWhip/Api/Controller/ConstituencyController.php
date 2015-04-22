<?php
/**
 * ConstituencyController.php
 * Definition of class ConstituencyController
 *
 * Created 01-Mar-2015 13:28:18
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Controller;

use JMS\Serializer\SerializerInterface;
use TheLgbtWhip\Api\External\PostcodeToConstituencyMappingInterface;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Repository\ConstituencyRepository;
use TheLgbtWhip\Api\Serializer\ContentTypeSerializerWrapper;



/**
 * ConstituencyController
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ConstituencyController extends AbstractController
{

    /**
     *
     * @var PostcodeToConstituencyMappingInterface
     */
    private $mapItClient;

    /**
     * @var ConstituencyRepository
     */
    private $constituencyRepository;
    
    /**
     *
     * @var ContentTypeSerializerWrapper
     */
    private $serializerWrapper;



    /**
     * @param PostcodeToConstituencyMappingInterface $mapItClient
     * @param ConstituencyRepository $constituencyRepository
     * @param ContentTypeSerializerWrapper $serializerWrapper
     */
    public function __construct(
        PostcodeToConstituencyMappingInterface $mapItClient,
        ConstituencyRepository $constituencyRepository,
        ContentTypeSerializerWrapper $serializerWrapper
    ) {
        $this->mapItClient = $mapItClient;
        $this->constituencyRepository = $constituencyRepository;
        $this->serializerWrapper = $serializerWrapper;
    }
    
    public function setResponse(\Slim\Http\Response $response)
    {
        parent::setResponse($response);
        
        $this->setUpResponseHeaders();
    }
    
    protected function setUpResponseHeaders()
    {
        $this->response->headers->set(
            'Content-Type',
            $this->serializerWrapper->getContentTypeFromFormat()
        );
    }
    
    /**
     * @param string $givenPostcode
     * @return Constituency
     */
    public function resolveByPostcodeAction($givenPostcode)
    {
        return $this->response->setBody(
            $this->serializerWrapper->serialize(
                $this->mapItClient->getConstituencyFromPostcode($givenPostcode)
            )
        );
    }
    
    /*public function resolveByNameAction($name)
    {
        $this->response->headers->set('Content-Type', 'application/json');
        
        return $this->response->setBody(
            $this->serializer->serialize(
                new \StdClass(),
                'json'
            )
        );
    }*/

}
