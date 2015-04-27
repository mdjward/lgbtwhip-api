<?php

namespace TheLgbtWhip\Api\Model;

use InvalidArgumentException;
use UnexpectedValueException;



/**
 * View - mappable model class to encapsulate information about a candidate's
 * view on a certain issue
 * 
 * @author M.D.Ward <dev@mattdw.co.uk>
 * @see Issue
 * @see Candidate
 */
class View extends AbstractModelWithId
{
    
    /**
     * Indicates that the candidate would support the LGBT community
     * in legislation regarding this issue
     */
    const SUPPORTS = 'supports';
    
    /**
     * Indicates that the candidate would not support the LGBT community
     * in legislation regarding this issue
     */
    const DOES_NOT_SUPPORT = 'does not support';
    
    /**
     * Indicates that the candidate declined to answer when asked (due to party
     * policy, as an example)
     */
    const DECLINED_TO_ANSWER = 'declined to answer';
    
    
    
    /**
     *
     * @var Candidate
     */
    protected $candidate;
    
    /**
     *
     * @var Issue
     */
    protected $issue;
    
    /**
     *
     * @var string
     */
    protected $historicStance;
    
    /**
     *
     * @var integer
     */
    protected $historicSupport;
    
    /**
     *
     * @var string
     */
    protected $currentStance;
    
    /**
     *
     * @var integer
     */
    protected $currentSupport;
    
    
    
    /**
     * 
     * @return Candidate
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * 
     * @return Issue
     */
    public function getIssue()
    {
        return $this->issue;
    }

    /**
     * 
     * @return string
     */
    public function getHistoricStance()
    {
        return $this->historicStance;
    }

    /**
     * 
     * @return integer|null
     */
    public function getHistoricSupport()
    {
        return $this->historicSupport;
    }
    
    /**
     * 
     * @return string
     */
    public function getCurrentStance()
    {
        return $this->currentStance;
    }

    /**
     * 
     * @return integer|null
     */
    public function getCurrentSupport()
    {
        return $this->currentSupport;
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @return View
     */
    public function setCandidate(Candidate $candidate)
    {
        $this->candidate = $candidate;
        
        return $this;
    }

    /**
     * 
     * @param Issue $issue
     * @return View
     */
    public function setIssue(Issue $issue)
    {
        $this->issue = $issue;
        
        return $this;
    }
    
    /**
     * 
     * @param string $historicStance
     * @return View
     */
    public function setHistoricStance($historicStance)
    {
        $this->historicStance = $historicStance;
        
        return $this;
    }
    
    /**
     * 
     * @param integer $historicSupport
     * @return View
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function setHistoricSupport($historicSupport)
    {
        $this->historicSupport = $this->validateSupport($historicSupport);
        
        return $this;
    }

    /**
     * 
     * @param string $currentStance
     * @return View
     */
    public function setCurrentStance($currentStance)
    {
        $this->currentStance = $currentStance;
        
        return $this;
    }
    
    /**
     * 
     * @param integer $currentSupport
     * @return View
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function setCurrentSupport($currentSupport)
    {
        $this->currentSupport = $this->validateSupport($currentSupport);
        
        return $this;
    }
        
    /**
     * 
     * @param mixed $givenSupportValue
     * @return string
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    private function validateSupport($givenSupportValue)
    {
        if (!is_string($givenSupportValue)) {
            throw new InvalidArgumentException(
                'Given support value should be provided as an integer'
            );
        }
        
        switch ($givenSupportValue) {
            case self::SUPPORTS:
            case self::DOES_NOT_SUPPORT:
            case self::DECLINED_TO_ANSWER:
                return $givenSupportValue;
        }
        
        throw new UnexpectedValueException(
            "Unrecognised support value '{$givenSupportValue}'"
        );
    }

}