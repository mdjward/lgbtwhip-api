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
use TheLgbtWhip\Api\External\Client\MapIt\MapItClientInterface;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Repository\ConstituencyRepository;



/**
 * ConstituencyController
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ConstituencyController extends AbstractController
{

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
     * @var SerializerInterface
     */
    private $serializer;



    /**
     * @param MapItClientInterface $mapItClient
     * @param ConstituencyRepository $constituencyRepository
     * @param SerializerInterface $serializer
     */
    public function __construct(
        MapItClientInterface $mapItClient,
        ConstituencyRepository $constituencyRepository,
        SerializerInterface $serializer
    ) {
        $this->mapItClient = $mapItClient;
        $this->constituencyRepository = $constituencyRepository;
        $this->serializer = $serializer;
    }

    /**
     * @param string $givenPostcode
     * @return Constituency
     */
    public function resolveByPostcodeAction($givenPostcode)
    {
        $this->response->headers->set('Content-Type', 'application/json');
        
        return $this->response->setBody(
            $this->serializer->serialize(
                $this->mapItClient->getConstituencyFromPostcode($givenPostcode),
                'json'
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
