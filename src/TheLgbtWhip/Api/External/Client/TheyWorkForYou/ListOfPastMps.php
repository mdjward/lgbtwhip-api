<?php
/**
 * ListOfPastMps.php
 * Definition of class ListOfPastMps
 * 
 * Created 26-Apr-2015 18:21:02
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client\TheyWorkForYou;

use DateTime;
use InvalidArgumentException;
use TheLgbtWhip\Api\Model\Candidate;



/**
 * ListOfPastMps
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ListOfPastMps implements PastMpSearchInterface
{
    
    /**
     *
     * @var DateTime
     */
    protected $parliamentStartDate;
    
    /**
     *
     * @var arrays
     */
    protected $mps;
    
    
    
    /**
     * 
     * @param DateTime $parliamentStartDate
     */
    public function __construct(DateTime $parliamentStartDate)
    {
        $this->setParliamentStartDate($parliamentStartDate);
    }
    
    /**
     * 
     * @return DateTime
     */
    public function getParliamentStartDate()
    {
        return $this->parliamentStartDate;
    }

    /**
     * 
     * @return array
     */
    public function getMps()
    {
        return array_values($this->mps);
    }
    
    /**
     * 
     * @param DateTime $parliamentStartDate
     * @return ListOfPastMps
     */
    public function setParliamentStartDate(DateTime $parliamentStartDate)
    {
        $this->parliamentStartDate = $parliamentStartDate;
        
        return $this;
    }
    
    /**
     * 
     * @param array $mp
     * @return ListOfPastMps
     * @throws InvalidArgumentException
     */
    public function addMpDetails(array $mp)
    {
        if (!isset($mp['name']) || !isset($mp['constituency']) || !isset($mp['person_id'])) {
            throw new InvalidArgumentException(
                'MP details must provide name, details and a person ID for further querying'
            );
        }

        $this->mps[$mp['name'] . '-' . $mp['constituency']] = $mp;

        return $this;
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @return integer|null
     */
    public function findPastMpId(Candidate $candidate) {
        $key = $candidate->getName() . '-' . $candidate->getConstituency()->getName();
        
        return (isset($this->mps[$key]) ? $this->mps[$key]['person_id'] : null);
    }
    
}
