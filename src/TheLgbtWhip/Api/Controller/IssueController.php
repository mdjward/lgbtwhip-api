<?php
namespace TheLgbtWhip\Api\Controller;

use DateTime;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use ReflectionClass;
use TheLgbtWhip\Api\External\Client\ThePublicWhip\ThePublicWhipClientInterface;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Model\Issue;
use TheLgbtWhip\Api\Model\Vote;



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
     * @var SerializerInterface
     */
    protected $serializer;
    
    
    
    /**
     * 
     * @param ThePublicWhipClientInterface $thePublicWhipClient
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ThePublicWhipClientInterface $thePublicWhipClient,
        SerializerInterface $serializer
    ) {
        $this->thePublicWhipClient = $thePublicWhipClient;
        $this->serializer = $serializer;
    }
    
    /**
     * 
     * @param integer $number
     * @param string $date
     */
    public function testAction($number, $date)
    {
        $candidateReflection = new ReflectionClass('TheLgbtWhip\Api\Model\Candidate');
        $idProperty = $candidateReflection->getProperty('id');
        $idProperty->setAccessible(true);
        
        $issue = new Issue();
        $issue
            ->setTitle('Arbitrary issue')
            ->setDescription('Description of an arbitrary issue')
            ->setRelevantAct('Arbitrary Act of 2015')
            ->setPublicWhipId(12345)
            ->setPublicWhipDate(DateTime::createFromFormat('Y-m-d', '2015-01-01'))
            ->setIsProgressiveStance(true)
        ;
        
        $candidate1 = new Candidate();
        $idProperty->setValue($candidate1, 1);
        $candidate1->setName("CANDIDATE 1");
        
        $candidate2 = new Candidate();
        $idProperty->setValue($candidate2, 2);
        $candidate2->setName("CANDIDATE 2");
        
        $candidate1Vote = new Vote();
        $candidate1Vote->setIssue($issue)->setCandidate($candidate1)->setVoteCast(Vote::AYE);
        $candidate1->addVote($candidate1Vote);
        $issue->addVote($candidate1Vote);
        
        $candidate2Vote = new Vote();
        $candidate2Vote->setIssue($issue)->setCandidate($candidate2)->setVoteCast(Vote::NAY);
        $candidate2->addVote($candidate2Vote);
        $issue->addVote($candidate2Vote);
        
        $constituency = new Constituency();
        $constituency->setName("CONSTITUENCY");
        
        $constituency->addCandidate($candidate1)->addCandidate($candidate2);
        $candidate1->setConstituency($constituency);
        $candidate2->setConstituency($constituency);

        $constituencyJson = $this->serializer->serialize($constituency, 'json');
        $constituencyXml = $this->serializer->serialize($constituency, 'xml');
        
        $candidateJson = $this->serializer->serialize($candidate1, 'json');
        $candidateXml = $this->serializer->serialize($candidate1, 'xml');
        
        $issue = new Issue();
        $issue
            ->setTitle('Same Sex Marriage')
            ->setRelevantAct('Marriage (Same-sex Couples) Bill')
            ->setDescription('Third reading in the House of Commons')
            ->setIsProgressiveStance(true)
            ->setPublicWhipId($number)
            ->setPublicWhipDate(DateTime::createFromFormat('Y-m-d', $date))
        ;
        
        foreach ($this->thePublicWhipClient->getVotesForIssue($issue) as $vote) {
            $issue->addVote($vote);
        };
        
        $this->response->headers->set('Content-Type', 'text/json');
        $this->response->setBody(
            $this->serializer->serialize($issue, 'json')
        );
    }
    
}
