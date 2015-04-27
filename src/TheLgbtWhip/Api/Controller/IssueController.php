<?php
namespace TheLgbtWhip\Api\Controller;

use Exception;
use JMS\Serializer\SerializerInterface;
use TheLgbtWhip\Api\External\CandidateIdResolverInterface;
use TheLgbtWhip\Api\Manager\CandidateManager;
use TheLgbtWhip\Api\Model\View;
use TheLgbtWhip\Api\Repository\IssueRepository;
use TheLgbtWhip\Api\Serializer\ContentTypeSerializerWrapper;



/**
 * Description of IssueController
 *
 * @author matt
 */
class IssueController extends AbstractSerializingController
{
    
    
    
    /**
     *
     * @var CandidateIdResolverInterface
     */
    protected $candidateIdResolver;
    
    /**
     *
     * @var CandidateManager
     */
    protected $candidateManager;
    
    /**
     *
     * @var IssueRepository
     */
    protected $issueRepository;
    
    /**
     *
     * @var ContentTypeSerializerWrapper
     */
    protected $incomingSerializerWrapper;
    
    
    
    /**
     * 
     * @param CandidateIdResolverInterface $candidateIdResolver
     * @param CandidateManager $candidateManager
     * @param IssueRepository $issueRepository
     * @param ContentTypeSerializerWrapper $incomingSerializerWrapper
     * @param ContentTypeSerializerWrapper $outgoingSerializerWrapper
     */
    public function __construct(
        CandidateIdResolverInterface $candidateIdResolver,
        CandidateManager $candidateManager,
        IssueRepository $issueRepository,
        ContentTypeSerializerWrapper $incomingSerializerWrapper,
        ContentTypeSerializerWrapper $outgoingSerializerWrapper
    ) {
        parent::__construct($outgoingSerializerWrapper);
        
        $this->candidateIdResolver = $candidateIdResolver;
        $this->candidateManager = $candidateManager;
        $this->issueRepository = $issueRepository;
        $this->incomingSerializerWrapper = $incomingSerializerWrapper;
    }
    
    public function saveView($candidateId, $issueUriKey)
    {
        if (($candidate = $this->candidateIdResolver->resolveCandidateById($candidateId)) === null) {
            throw new Exception('Unrecognised candidate ID', 404);
        }
        
        if (($issue = $this->issueRepository->findOneByUriKey($issueUriKey)) === null) {
            throw new Exception('Unrecognised issue URI string', 404);
        }
        
        $body = $this->request->getBody();
        
        /* @var $view View */
        $view = $this->incomingSerializerWrapper->deserialize(
            $body,
            View::class
        );
        
        $view
            ->setCandidate($candidate)
            ->setIssue($issue)
        ;
        
        $this->candidateManager->saveView($view);
        
        return $this->response->setBody(
            $this->serializerWrapper->serialize($candidate->addView($view))
        );
    }
    
}
