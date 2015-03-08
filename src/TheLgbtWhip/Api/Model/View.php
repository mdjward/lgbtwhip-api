<?php

namespace TheLgbtWhip\Api\Model;

class View extends AbstractModelWithId
{
    
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
     * @var string
     */
    protected $currentStance;
    
    
    
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
     * @return string
     */
    public function getCurrentStance()
    {
        return $this->currentStance;
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
     * @param string $currentStance
     * @return View
     */
    public function setCurrentStance($currentStance)
    {
        $this->currentStance = $currentStance;
        
        return $this;
    }

} 