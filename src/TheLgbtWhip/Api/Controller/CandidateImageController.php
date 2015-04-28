<?php
/**
 * CandidateImageController.php
 * Definition of class CandidateImageController
 * 
 * Created 28-Apr-2015 09:28:20
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Controller;

use Exception;
use TheLgbtWhip\Api\External\CandidateIdResolverInterface;
use TheLgbtWhip\Api\Image\CandidateImageManager;
use TheLgbtWhip\Api\Image\ImageResponseWrapper;
use TheLgbtWhip\Api\Model\Candidate;



/**
 * CandidateImageController
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CandidateImageController extends AbstractController
{
    
    /**
     *
     * @var CandidateIdResolverInterface
     */
    protected $candidateIdResolver;
    
    /**
     * 
     * @var CandidateImageManager
     */
    protected $candidateImageManager;



    /**
     * 
     * @param CandidateIdResolverInterface $candidateIdResolver
     * @param CandidateImageManager $candidateImageManager
     */
    public function __construct(
        CandidateIdResolverInterface $candidateIdResolver,
        CandidateImageManager $candidateImageManager
    ) {
        $this->candidateIdResolver = $candidateIdResolver;
        $this->candidateImageManager = $candidateImageManager;
    }

    /**
     * 
     * @param integer $candidateId
     * @return mixed
     */
    public function getCandidateImageAction($candidateId)
    {
        return $this->sendResponse(
            $this->candidateImageManager->loadImageForCandidate(
                $this->findCandidate($candidateId)
            )
        );
    }

    /**
     * 
     * @param integer $candidateId
     * @return mixed
     */
    public function putCandidateImageAction($candidateId)
    {
        return $this->sendResponse(
            $this->candidateImageManager->setImageForCandidate(
                $this->findCandidate($candidateId),
                trim($this->request->getBody())
            )
        );
    }
    
    protected function sendResponse(ImageResponseWrapper $imageResponse)
    {
        $this->response->headers->set(
            'Content-Type', 'image/' . $imageResponse->getImageType()
        );
        
        return $this->response->setBody($imageResponse->getImageData());
    }
    
    /**
     * 
     * @param integer $candidateId
     * @return Candidate
     * @throws Exception
     */
    protected function findCandidate($candidateId) {
        if (($candidate = $this->candidateIdResolver->resolveCandidateById($candidateId))) {
            return $candidate;
        }
        
        throw new Exception(
            'Could not load candidate by id ',
            404
        );
    }
    
}
