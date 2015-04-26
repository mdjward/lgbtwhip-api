<?php
/**
 * ConstituenciesWrapper.php
 * Definition of class ConstituenciesWrapper
 * 
 * Created 26-Apr-2015 16:34:43
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Model\ArrayWrapper;



/**
 * ConstituenciesWrapper
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ConstituenciesWrapper
{
    
    /**
     *
     * @var array
     */
    protected $constituencies;
    
    
    
    /**
     * 
     * @param array $constituencies
     */
    public function __construct(array $constituencies)
    {
        $this->setConstituencies($constituencies);
    }
    
    /**
     * 
     * @return array
     */
    public function getConstituencies()
    {
        return $this->constituencies;
    }

    /**
     * 
     * @param array $constituencies
     * @return ConstituenciesWrapper
     */
    public function setConstituencies(array $constituencies)
    {
        $this->constituencies = $constituencies;
        
        return $this;
    }
    
}
