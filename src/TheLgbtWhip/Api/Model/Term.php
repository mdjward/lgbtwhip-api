<?php
namespace TheLgbtWhip\Api\Model;

use DateTime;



/**
 * Description of Term
 *
 * @author matt
 */
class Term extends AbstractModelWithId
{
    
    /**
     *
     * @var Candidate
     */
    protected $candidate;
    
    /**
     *
     * @var Party
     */
    protected $party;
    
    /**
     *
     * @var DateTime
     */
    protected $startDate;
    
    /**
     *
     * @var DateTime|null
     */
    protected $endDate;
    
    
    
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
     * @return Party
     */
    public function getParty()
    {
        return $this->party;
    }

    /**
     * 
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * 
     * @return DateTime|null
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * 
     * @param Candidate $candidate
     * @return Term
     */
    public function setCandidate(Candidate $candidate)
    {
        $this->candidate = $candidate;
        
        return $this;
    }

    /**
     * 
     * @param Party $party
     * @return Term
     */
    public function setParty(Party $party)
    {
        $this->party = $party;
        
        return $this;
    }

    /**
     * 
     * @param DateTime $startDate
     * @return Term
     */
    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;
        
        return $this;
    }

    /**
     * 
     * @param DateTime|null $endDate
     * @return Term
     */
    public function setEndDate(DateTime $endDate = null)
    {
        $this->endDate = $endDate;
        
        return $this;
    }
    
}
