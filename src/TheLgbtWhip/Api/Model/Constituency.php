<?php
namespace TheLgbtWhip\Api\Model;

use Doctrine\Common\Collections\ArrayCollection;



/**
 * 
 */
class Constituency extends AbstractModelWithId
{
    
    /**
     *
     * @var string
     */
    protected $name;
    
    /**
     *
     * @var Collection
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
     * @return Collection
     */
    public function getCandidates()
    {
        return $this->candidates;
    }

    /**
     * 
     * @param string $name
     * @return Constituency
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * 
     * @param Candidate $candidate
     * @return Constituency
     */
    public function addCandidate(Candidate $candidate)
    {
        $this->candidates->add($candidate);
        
        return $this;
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @return Constituency
     */
    public function removeCandidate(Candidate $candidate)
    {
        $this->candidates->removeElement($candidate);
        
        return $this;
    }

}
