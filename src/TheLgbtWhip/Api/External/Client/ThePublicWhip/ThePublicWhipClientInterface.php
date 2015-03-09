<?php
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use TheLgbtWhip\Api\Model\Issue;

/**
 *
 * @author matt
 */
interface ThePublicWhipClientInterface
{
    
    public function getVotesForIssue(Issue $issue);
    
}
