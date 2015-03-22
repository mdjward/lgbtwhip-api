<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace TheLgbtWhip\Api\External\Client\YourNextMp;

use TheLgbtWhip\Api\Model\Constituency;


/**
 *
 * @author matt
 */
interface YourNextMpClientInterface
{
    
    public function getCandidatesForConstituency(Constituency $constituency);
    
}
