<?php
/**
 * IssueController.php
 * Definition of class IssueController
 * 
 * Created 28-Apr-2015 09:31:24
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Controller;

use TheLgbtWhip\Api\Repository\IssueRepository;
use TheLgbtWhip\Api\Serializer\ContentTypeSerializerWrapper;



/**
 * IssueController
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class IssueController extends AbstractSerializingController
{
    
    /**
     *
     * @var IssueRepository
     */
    protected $issueRepository;
    
    
    /**
     * 
     * @param IssueRepository $issueRepository
     */
    public function __construct(
        IssueRepository $issueRepository,
        ContentTypeSerializerWrapper $serializerWrapper
    ) {
        parent::__construct($serializerWrapper);

        $this->issueRepository = $issueRepository;
    }
    
    public function getAllIssuesAction()
    {
        return $this->response->setBody(
            $this->serializerWrapper->serialize(
                $this->issueRepository->findAll()
            )
        );
    }
    
}
