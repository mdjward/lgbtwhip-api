<?php
namespace TheLgbtWhip\Api\Model;

use InvalidArgumentException;
use UnexpectedValueException;




/**
 * 
 */
class Vote extends AbstractModelWithId
{
    
    /**
     * 
     */
    const AYE = 'aye';
    
    /**
     * 
     */
    const NAY = 'nay';
    
    /**
     * 
     */
    const ABSTAIN = 'abstain';
    
    
    
    /**
     *
     * @var Issue
     */
    protected $issue;
    
    /**
     *
     * @var Candidate
     */
    protected $candidate;
    
    /**
     *
     * @var string
     */
    protected $voteCast;
    
    
    
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
     * @return Candidate
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * 
     * @return string
     */
    public function getVoteCast()
    {
        return $this->voteCast;
    }

    /**
     * 
     * @param Issue $issue
     * @return Vote
     */
    public function setIssue(Issue $issue)
    {
        $this->issue = $issue;
        
        return $this;
    }
        
    /**
     * 
     * @param Candidate $candidate
     * @return Vote
     */
    public function setCandidate(Candidate $candidate)
    {
        $this->candidate = $candidate;
        
        return $this;
    }

    /**
     * 
     * @param string $voteCast
     * @return Vote
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function setVoteCast($voteCast)
    {
        if (!is_string($voteCast)) {
            throw new InvalidArgumentException(
                'Vote cast must be given as a string'
            );
        }
        
        switch ($voteCast) {
            case self::AYE:
            case self::NAY:
            case self::ABSTAIN:
                $this->voteCast = $voteCast;

                return $this;
        }
        
        throw new UnexpectedValueException(
            "Invalid vote cast value '{$voteCast}'"
        );
    }
    
}
