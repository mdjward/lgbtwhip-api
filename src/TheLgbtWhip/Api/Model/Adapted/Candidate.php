<?php
/**
 * Candidate.php
 * Definition of class Candidate
 * 
 * Created 24-Apr-2015 09:08:52
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Model\Adapted;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use TheLgbtWhip\Api\Model\Candidate as BaseCandidate;



/**
 * Candidate
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class Candidate extends BaseCandidate
{
    
    /**
     *
     * @var array 
     */
    protected $issues = [];
    
    
    
    /**
     * 
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 
     * @return array
     */
    public function getIssues()
    {
        ksort($this->issues);
        
        return array_values($this->issues);
    }
    
    /**
     * 
     * @param Issue $issue
     * @return Candidate
     */
    public function addIssue(Issue $issue)
    {
        $this->issues[$issue->getId()] = $issue;
        
        return $this;
    }
    
    /**
     * 
     * @param Issue $issue
     * @return Candidate
     */
    public function removeIssue(Issue $issue)
    {
        $issueId = $issue->getId();
        
        if (isset($this->issues[$issueId])) {
            unset($this->issues[$issueId]);
        }
        
        return $this;
    }
    
}
