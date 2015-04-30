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
    const SUPPORT = 'support';
    
    /**
     * Indicates that the candidate would abstain in a vote for legislation
     * on this issue
     */
    const ABSTAIN = 'abstain';
    
    /**
     * Indicates that the candidate oppose legislation regarding this issue
     */
    const OPPOSE = 'oppose';
    
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
                'Given support value should be provided as a string'
            );
        }
        
        switch ($givenSupportValue) {
            case self::SUPPORT:
            case self::OPPOSE:
            case self::ABSTAIN:
            case self::DECLINED_TO_ANSWER:
                return $givenSupportValue;
        }
        
        throw new UnexpectedValueException(
            sprintf(
                "Unrecognised support value '%s'; expected: one of '%s'",
                $givenSupportValue,
                implode(
                    "', '",
                    [
                        self::SUPPORT,
                        self::OPPOSE,
                        self::ABSTAIN,
                        self::DECLINED_TO_ANSWER,
                    ]
                )
            )
            
        );
    }

}