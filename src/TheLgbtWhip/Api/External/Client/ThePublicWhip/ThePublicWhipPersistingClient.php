<?php
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use TheLgbtWhip\Api\Model\Issue;
use TheLgbtWhip\Api\Repository\IssueRepository;



/**
 * Description of ThePublicWhipPersistingClient
 *
 * @author matt
 */
class ThePublicWhipPersistingClient implements ThePublicWhipClientInterface
{
    
    /**
     *
     * @var ThePublicWhipClient
     */
    protected $realClient;
    
    /**
     *
     * @var IssueRepository
     */
    protected $issueRepository;
    
    
    
    /**
     * 
     * @param \TheLgbtWhip\Api\External\Client\ThePublicWhip\ThePublicWhipClient $realClient
     * @param IssueRepository $issueRepository
     */
    public function __construct(
        ThePublicWhipClient $realClient,
        IssueRepository $issueRepository
    ) {
        $this->realClient = $realClient;
    }
    
    public function getVotesForIssue(Issue $issue)
    {
        
    }
    
}
