<?php
namespace TheLgbtWhip\Api\Model;

/**
 * Description of AbstractModelWithId
 *
 * @author matt
 */
abstract class AbstractModelWithId
{
    
    /**
     *
     * @var integer|null
     */
    protected $id;
    
    
    
    /**
     * 
     * @return integer|null
     */
    public function getId()
    {
        return $this->id;
    }
    
}
