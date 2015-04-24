<?php
/**
 * IssueAdapterInterface.php
 * Definition of interface IssueAdapterInterface
 * 
 * Created 24-Apr-2015 09:17:10
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Adapter;

use TheLgbtWhip\Api\Model\Candidate;



/**
 * IssueAdapterInterface
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
interface IssueAdapterInterface
{
    /**
     * 
     * @param Candidate $candidate
     * @return array
     */
    public function adaptVotesAndViews(Candidate $candidate);
    
}
