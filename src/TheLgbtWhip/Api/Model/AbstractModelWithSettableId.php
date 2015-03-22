<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace TheLgbtWhip\Api\Model;

/**
 * Description of AbstractModelWithSettableId
 *
 * @author matt
 */
abstract class AbstractModelWithSettableId extends AbstractModelWithId
{
    
    /**
     * 
     * @param integer $id
     * @return AbstractModelWithSettableId
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
}
