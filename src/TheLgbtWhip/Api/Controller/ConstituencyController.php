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

use TheLgbtWhip\Api\External\Client\MapItClient;
use TheLgbtWhip\Api\Model\View\Constituency;
use TheLgbtWhip\Api\Repository\ConstituencyRepository;


/**
 * ConstituencyController
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ConstituencyController
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
     * @param MapItClient $mapItClient
     * @param \TheLgbtWhip\Api\Repository\ConstituencyRepository $constituencyRepository
     */
    public function __construct(MapItClient $mapItClient, ConstituencyRepository $constituencyRepository) {
        $this->mapItClient = $mapItClient;
        $this->constituencyRepository = $constituencyRepository;
    }

    /**
     * @param string $givenPostcode
     * @return \TheLgbtWhip\Api\Model\View\Constituency
     */
    public function resolveByPostcodeAction($givenPostcode)
    {
        $id = $this->mapItClient->getConstituencyFromPostcode($givenPostcode);
        return $this->constituencyRepository->find($id);
    }
    
}
