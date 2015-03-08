<?php

namespace TheLgbtWhip\Api\Model;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;



/**
 * 
 */
class Issue extends AbstractModelWithId
{
    
    /**
     *
     * @var string
     */
    protected $title;
    
    /**
     *
     * @var string
     */
    protected $description;
    
    /**
     *
     * @var string
     */
    protected $relevantAct;
    
    /**
     *
     * @var string
     */
    protected $url;
    
    /**
     *
     * @var boolean
     */
    protected $isProgressiveStance;
    
    /**
     *
     * @var id
     */
    protected $publicWhipId;
    
    /**
     *
     * @var DateTime
     */
    protected $publicWhipDate;
    
    /**
     *
     * @var Collection<Vote>
     */
    protected $votes;
    
    
    
    /**
     * 
     */
    public function __construct()
    {
        $this->votes = new ArrayCollection();
    }
    
    /**
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 
     * @return string
     */
    public function getRelevantAct()
    {
        return $this->relevantAct;
    }

    /**
     * 
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 
     * @return boolean
     */
    public function getIsProgressiveStance()
    {
        return $this->isProgressiveStance;
    }

    /**
     * 
     * @return integer
     */
    public function getPublicWhipId()
    {
        return $this->publicWhipId;
    }

    /**
     * 
     * @return DateTime
     */
    public function getPublicWhipDate()
    {
        return $this->publicWhipDate;
    }

    /**
     * 
     * @return Collection<Vote>
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * 
     * @param string $title
     * @return Issue
     */
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }

    /**
     * 
     * @param string $description
     * @return Issue
     */
    public function setDescription($description)
    {
        $this->description = $description;
        
        return $this;
    }

    /**
     * 
     * @param string $relevantAct
     * @return Issue
     */
    public function setRelevantAct($relevantAct)
    {
        $this->relevantAct = $relevantAct;
        
        return $this;
    }

    /**
     * 
     * @param string $url
     * @return Issue
     */
    public function setUrl($url)
    {
        $this->url = $url;
        
        return $this;
    }

    /**
     * 
     * @param boolean $isProgressiveStance
     * @return Issue
     */
    public function setIsProgressiveStance($isProgressiveStance)
    {
        $this->isProgressiveStance = $isProgressiveStance;
        
        return $this;
    }

    /**
     * 
     * @param integer $publicWhipId
     * @return Issue
     */
    public function setPublicWhipId($publicWhipId)
    {
        $this->publicWhipId = $publicWhipId;
        
        return $this;
    }
    
    /**
     * 
     * @param DateTime $publicWhipDate
     * @return Issue
     */
    public function setPublicWhipDate(DateTime $publicWhipDate)
    {
        $this->publicWhipDate = $publicWhipDate;
        
        return $this;
    }

    /**
     * 
     * @param Vote $vote
     * @return Issue
     */
    public function addVote(Vote $vote)
    {
        $this->votes->add($vote);
        
        return $this;
    }

    /**
     * 
     * @param Vote $vote
     * @return Issue
     */
    public function removeVote(Vote $vote)
    {
        $this->votes->removeElement($vote);
        
        return $this;
    }
    
} 