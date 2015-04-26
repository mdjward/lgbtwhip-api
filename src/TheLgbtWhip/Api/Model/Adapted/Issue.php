<?php
/**
 * Issue.php
 * Definition of class Issue
 * 
 * Created 24-Apr-2015 09:04:49
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Model\Adapted;

use TheLgbtWhip\Api\Model\Issue as BaseIssue;
use TheLgbtWhip\Api\Model\View;
use TheLgbtWhip\Api\Model\Vote;



/**
 * Issue
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class Issue extends BaseIssue
{
    
    /**
     *
     * @var View
     */
    protected $view;
    
    /**
     *
     * @var Vote
     */
    protected $vote;
    
    
    
    /**
     * 
     * @param integer $id
     * @return Issue
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * 
     * @return type
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * 
     * @param View $view
     * @return Issue
     */
    public function setView(View $view)
    {
        $this->view = $view;
        
        return $this;
    }

    /**
     * 
     * @param Vote $pastVote
     * @return Issue
     */
    public function setVote(Vote $vote)
    {
        $this->vote = $vote;
        
        return $this;
    }

}
