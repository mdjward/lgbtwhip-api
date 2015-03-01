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

use Slim\Http\Response;
use TheLgbtWhip\Api\External\Client\MapItClient;
use TheLgbtWhip\Api\Model\View\Constituency;
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
     * @var MapItClient
     */
    private $mapItClient;

    /**
     * @var ConstituencyRepository
     */
    private $constituencyRepository;
    /**
     * @var \Slim\Http\Response
     */
    private $response;



    /**
     * @param \Slim\Http\Response $response
     * @param MapItClient $mapItClient
     * @param ConstituencyRepository $constituencyRepository
     */
    public function __construct(Response $response, MapItClient $mapItClient, ConstituencyRepository $constituencyRepository)
    {
        $this->response = $response;
        $this->mapItClient = $mapItClient;
        $this->constituencyRepository = $constituencyRepository;
    }

    /**
     * @param string $givenPostcode
     * @return Constituency
     */
    public function resolveByPostcodeAction($givenPostcode)
    {
        $id = $this->mapItClient->getConstituencyFromPostcode($givenPostcode);
        $constituency = $this->constituencyRepository->find($id);
        if (is_null($constituency)) {
            $this->response->setStatus(404);
            return null;
        } else {
            return $constituency;
        }
    }

}
