<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TheLgbtWhip\Api\External\Client\MapIt;

/**
 *
 * @author matt
 */
interface MapItClientInterface
{
    
    /**
     * 
     * @param string $postcode
     * @return Constituency
     */
    public function getConstituencyFromPostcode($postcode);
    
}
