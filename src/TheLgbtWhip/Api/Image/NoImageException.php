<?php
/**
 * NoImageException.php
 * Definition of class NoImageException
 * 
 * Created 28-Apr-2015 09:54:11
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Image;

use Exception;
use TheLgbtWhip\Api\Model\Candidate;



/**
 * NoImageException
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class NoImageException extends Exception
{
    
    /**
     *
     * @var Candidate
     */
    protected $candidate;
    
    
    
    /**
     * 
     * @param Candidate $candidate
     */
    public function __construct(Candidate $candidate)
    {
        parent::__construct(
            'No image found for candidate ' . $candidate->getId(),
            0,
            null
        );
        
        $this->candidate = $candidate;
    }

    /**
     * 
     * @return Candidate
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

}
