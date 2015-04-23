<?php

namespace TheLgbtWhip\Api\Model;

use Doctrine\Common\Collections\ArrayCollection;



/**
 * 
 */
class Candidate extends AbstractModelWithSettableId
{
    
    /**
     *
     * @var Party
     */
    protected $party;
    
    /**
     *
     * @var Constituency
     */
    protected $constituency;
    
    /**
     *
     * @var string
     */
    protected $name;
    
    /**
     *
     * @var string 
     */
    protected $twitter;
    
    /**
     *
     * @var string 
     */
    protected $website;
    
    /**
     *
     * @var string 
     */
    protected $wikipedia;
    
    /**
     *
     * @var string 
     */
    protected $email;
    
    /**
     *
     * @var string 
     */
    protected $photo;
    
    /**
     *
     * @var Collection
     */
    protected $termsAsMp;
    
    /**
     *
     * @var Collection
     */
    protected $votes;
    
    /**
     *
     * @var Collection
     */
    protected $views;
    
    
    
    /**
     * 
     */
    public function __construct()
    {
        $this->termsAsMp = new ArrayCollection();
        $this->votes = new ArrayCollection();
        $this->views = new ArrayCollection();
    }
    
    /**
     * 
     * @return Constituency
     */
    public function getConstituency()
    {
        return $this->constituency;
    }

    /**
     * 
     * @return string
     */
    public function getParty()
    {
        return $this->party;
    }

    /**
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * 
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * 
     * @return string
     */
    public function getWikipedia()
    {
        return $this->wikipedia;
    }

    /**
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * 
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }
    
    /**
     * 
     * @return Terms
     */
    public function getTermsAsMp()
    {
        return $this->termsAsMp;
    }

    /**
     * 
     * @return Collection
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * 
     * @return Collection
     */
    public function getViews()
    {
        return $this->views;
    }
    
    /**
     * 
     * @return array
     */
    public function getIssues()
    {
        $issues = [];
        
        /* @var $view View */
        foreach ($this->views as $view) {
            $issue = $view->getIssue();
            $issueId = $issue->getId();
            
            if (!isset($issues[$issueId])) {
                $issues[$issueId] = $issue;
            }
        }
        
        /* @var $vote Vote */
        foreach ($this->votes as $vote) {
            $issue = $vote->getIssue();
            $issueId = $issue->getId();
            
            if (!isset($issues[$issueId])) {
                $issues[$issueId] = $issue;
            }
        }
        
        return $issues;
    }
    
    /**
     * 
     * @param Constituency $constituency
     * @return Candidate
     */
    public function setConstituency(Constituency $constituency)
    {
        $this->constituency = $constituency;
        
        return $this;
    }
        
    /**
     * 
     * @param Party $party
     * @return Candidate
     */
    public function setParty(Party $party)
    {
        $this->party = $party;
        
        return $this;
    }

    /**
     * 
     * @param string $name
     * @return Candidate
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * 
     * @param string $twitter
     * @return Candidate
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
        
        return $this;
    }

    /**
     * 
     * @param string $website
     * @return Candidate
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        
        return $this;
    }

    /**
     * 
     * @param string $wikipedia
     * @return Candidate
     */
    public function setWikipedia($wikipedia)
    {
        $this->wikipedia = $wikipedia;
        
        return $this;
    }

    /**
     * 
     * @param string $email
     * @return Candidate
     */
    public function setEmail($email)
    {
        $this->email = $email;
        
        return $this;
    }

    /**
     * 
     * @param string $photo
     * @return Candidate
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        
        return $this;
    }
    
    /**
     * 
     * @param Vote $vote
     * @return Candidate
     */
    public function addVote(Vote $vote)
    {
        $this->votes->add($vote);
        
        return $this;
    }
    
    /**
     * 
     * @param Vote $vote
     * @return Candidate
     */
    public function removeVote(Vote $vote)
    {
        $this->votes->removeElement($vote);
        
        return $this;
    }

    /**
     * 
     * @param View $view
     * @return Candidate
     */
    public function addView(View $view)
    {
        $this->views->add($view);
        
        return $this;
    }
    
    /**
     * 
     * @param View $view
     * @return Candidate
     */
    public function removeView(View $view)
    {
        $this->views->removeElement($view);
        
        return $this;
    }
    
    /**
     * 
     * @param Term $term
     * @return Candidate
     */
    public function addTermAsMp(Term $term)
    {
        $this->termsAsMp->add($term);
        
        return $this;
    }
    
    /**
     * 
     * @param Term $term
     * @return Candidate
     */
    public function removeTermAsMp(Term $term)
    {
        $this->termsAsMp->remove($term);
        
        return $this;
    }

}
