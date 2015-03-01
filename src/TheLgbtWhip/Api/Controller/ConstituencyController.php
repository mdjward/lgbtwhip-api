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
     * 
     * @param MapItClient $mapItClient
     */
    public function __construct(MapItClient $mapItClient) {
        $this->mapItClient = $mapItClient;
    }

    /**
     * @param string $givenPostcode
     * @return \TheLgbtWhip\Api\Model\View\Constituency
     */
    public function resolveByPostcodeAction($givenPostcode)
    {
        $constituency = new Constituency();
        $constituency->name = $this->mapItClient->getConstituencyFromPostcode($givenPostcode);
        return $constituency;
    }
    
}
