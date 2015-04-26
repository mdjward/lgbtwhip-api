<?php
/**
 * PastParliamentDateAwareTrait.php
 * Definition of class PastParliamentDateAwareTrait
 * 
 * Created 26-Apr-2015 18:41:19
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client\TheyWorkForYou;

use DateTime;



/**
 * PastParliamentDateAwareTrait
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
trait PastParliamentDateAwareTrait
{
    
    /**
     *
     * @var array
     */
    protected $pastParliamentDates = [];
    
    
    
    /**
     * 
     * @param DateTime $date
     * @return TheyWorkForYouClient
     */
    public function addPastParliamentDate(DateTime $date)
    {
        $this->pastParliamentDates[(int) $date->format('Y')] = $date;
        
        return $this;
    }
    
}
