<?php
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use TheLgbtWhip\Api\External\VoteRetrieverInterface;
use TheLgbtWhip\Api\Model\Issue;
use TheLgbtWhip\Api\Repository\IssueRepository;



/**
 * Description of ThePublicWhipPersistingClient
 *
 * @author matt
 */
class ThePublicWhipPersistingClient implements VoteRetrieverInterface
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
     * @param ThePublicWhipClient $realClient
     * @param IssueRepository $issueRepository
     */
    public function __construct(
        ThePublicWhipClient $realClient,
        IssueRepository $issueRepository
    ) {
        $this->realClient = $realClient;
        $this->issueRepository = $issueRepository;
    }
    
    public function getVotesForIssue(Issue $issue)
    {
        ;
    }
    
}
