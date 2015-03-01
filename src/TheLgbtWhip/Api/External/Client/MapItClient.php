<?php

namespace TheLgbtWhip\Api\External\Client;



/**
 * MapItClient
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class MapItClient extends AbstractRestServiceClient
{
    public function getConstituencyFromPostcode($postcode)
    {
        return $postcode;
    }
}
