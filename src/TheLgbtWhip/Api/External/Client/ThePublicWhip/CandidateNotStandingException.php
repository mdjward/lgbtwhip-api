<?php
/**
 * CandidateNotStandingException.php
 * Definition of class CandidateNotStandingException
 * 
 * Created 24-Apr-2015 15:58:25
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;



/**
 * CandidateNotStandingException
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CandidateNotStandingException extends ThePublicWhipProcessingException
{
    
    /**
     *
     * @var string
     */
    private $candidateName;
    
    
    
    /**
     * 
     * @param string $candidateName
     */
    public function __construct($candidateName)
    {
        parent::__construct(
            'Candidate is not standing or could not be located'
        );
        
        $this->candidateName = $candidateName;
    }
    
    /**
     * 
     * @return string
     */
    public function getCandidateName()
    {
        return $this->candidateName;
    }
    
}
