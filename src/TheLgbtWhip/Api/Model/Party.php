<?php

namespace TheLgbtWhip\Api\Model;



/**
 * 
 */
class Party extends AbstractModelWithId
{
    /**
     *
     * @var string
     */
    protected $name;
    
    /**
     *
     * @var string 
     */
    protected $logo;
    
    /**
     *
     * @var string
     */
    protected $websiteUrl;
    
    /**
     *
     * @var string
     */
    protected $colour;
    
    /**
     *
     * @var Collection<Candidate>
     */
    protected $candidates;
    
    
    
    /**
     * 
     */
    public function __construct()
    {
        $this->candidates = new ArrayCollection();
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
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * 
     * @return string
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * 
     * @return string
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * 
     * @return Collection<Candidate>
     */
    public function getCandidates()
    {
        return $this->candidates;
    }

    /**
     * 
     * @param string $name
     * @return Party
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * 
     * @param string $logo
     * @return Party
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
        
        return $this;
    }

    /**
     * 
     * @param string $websiteUrl
     * @return Party
     */
    public function setWebsiteUrl($websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;
        
        return $this;
    }

    /**
     * 
     * @param string $colour
     * @return Party
     */
    public function setColour($colour)
    {
        $this->colour = $colour;
        
        return $this;
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @return Party
     */
    public function addCandidate(Candidate $candidate)
    {
        $this->candidates->add($candidate);
        
        return $this;
    }

    /**
     * 
     * @param Candidate $candidate
     * @return Party
     */
    public function removeCandidate(Candidate $candidate)
    {
        $this->candidates->removeElement($candidate);
        
        return $this;
    }

}
