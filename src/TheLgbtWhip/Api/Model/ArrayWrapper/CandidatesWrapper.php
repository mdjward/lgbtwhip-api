<?php
/**
 * CandidatesWrapper.php
 * Definition of class CandidatesWrapper
 * 
 * Created 26-Apr-2015 16:33:32
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Model\ArrayWrapper;



/**
 * CandidatesWrapper
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CandidatesWrapper
{
    
    /**
     *
     * @var array
     */
    protected $candidates;
    
    
    
    /**
     * 
     * @param array $candidates
     */
    public function __construct(array $candidates)
    {
        $this->setCandidates($candidates);
    }
    
    /**
     * 
     * @return array
     */
    public function getCandidates()
    {
        return $this->candidates;
    }

    /**
     * 
     * @param array $candidates
     * @return \TheLgbtWhip\Api\Model\ArrayWrapper\CandidatesWrapper
     */
    public function setCandidates(array $candidates)
    {
        $this->candidates = $candidates;
        
        return $this;
    }
    
}
