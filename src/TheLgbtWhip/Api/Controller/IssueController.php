<?php
namespace TheLgbtWhip\Api\Controller;

use DateTime;
use TheLgbtWhip\Api\External\Client\ThePublicWhip\ThePublicWhipClientInterface;
use TheLgbtWhip\Api\Model\Issue;



/**
 * Description of IssueController
 *
 * @author matt
 */
class IssueController extends AbstractController
{
    
    /**
     *
     * @var ThePublicWhipClientInterface
     */
    protected $thePublicWhipClient;
    
    
    
    /**
     * 
     * @param ThePublicWhipClientInterface $thePublicWhipClient
     */
    public function __construct(ThePublicWhipClientInterface $thePublicWhipClient)
    {
        $this->thePublicWhipClient = $thePublicWhipClient;
    }
    
    /**
     * 
     * @param integer $number
     * @param string $date
     */
    public function testAction($number, $date)
    {
        $issue = new Issue();
        $issue
            ->setTitle('Same Sex Marriage')
            ->setRelevantAct('Marriage (Same-sex Couples) Bill')
            ->setDescription('Third reading in the House of Commons')
            ->setIsProgressiveStance(true)
            ->setPublicWhipId($number)
            ->setPublicWhipDate(DateTime::createFromFormat('Y-m-d', $date))
        ;

        return $this->thePublicWhipClient->getVotesForIssue($issue);
    }
    
}
