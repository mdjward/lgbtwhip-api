<?php
namespace TheLgbtWhip\Api\Controller;

use Exception;
use TheLgbtWhip\Api\Adapter\CandidateAdapterInterface;
use TheLgbtWhip\Api\External\CandidateIdResolverInterface;
use TheLgbtWhip\Api\External\CandidateNameResolverInterface;
use TheLgbtWhip\Api\External\ExternalServiceException;
use TheLgbtWhip\Api\Manager\CandidateAndPartyManager;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Serializer\ContentTypeSerializerWrapper;



/**
 * Description of CandidateController
 *
 * @author matt
 */
class CandidateController extends AbstractSerializingController
{
    
    /**
     *
     * @var CandidateAndPartyManager 
     */
    protected $candidateAndPartyManager;
    
    /**
     *
     * @var CandidateIdResolver
     */
    protected $candidateIdResolver;
    
    /**
     *
     * @var CandidateNameResolver
     */
    protected $candidateNameResolver;
    
    /**
     *
     * @var CandidateAdapterInterface
     */
    protected $candidateAdapter;
    
    
    
    /**
     * 
     * @param CandidateAndPartyManager $candidateAndPartyManager
     * @param CandidateIdResolverInterface $candidateIdResolver
     * @param CandidateNameResolverInterface $candidateNameResolver
     * @param CandidateAdapterInterface $candidateAdapter
     * @param ContentTypeSerializerWrapper $serializerWrapper
     */
    public function __construct(
        CandidateAndPartyManager $candidateAndPartyManager,
        CandidateIdResolverInterface $candidateIdResolver,
        CandidateNameResolverInterface $candidateNameResolver,
        CandidateAdapterInterface $candidateAdapter,
        ContentTypeSerializerWrapper $serializerWrapper
    ) {
        parent::__construct($serializerWrapper);
        
        $this->candidateAndPartyManager = $candidateAndPartyManager;
        $this->candidateIdResolver = $candidateIdResolver;
        $this->candidateNameResolver = $candidateNameResolver;
        $this->candidateAdapter = $candidateAdapter;
    }
    
    /**
     * 
     * @param integer $id
     * @return Candidate
     * @throws Exception
     */
    public function resolveByIdAction($id)
    {
        try {
            return $this->response->setBody(
                $this->serializerWrapper->serialize(
                    $this->candidateAdapter->adaptCandidate(
                        $this->candidateIdResolver->resolveCandidateById($id)
                    )
                )
            );
        } catch (ExternalServiceException $ex) {
            throw new Exception($ex->getMessage(), 404, $ex);
        }
    }

    /**
     * 
     * @param string $name
     * @return Candidate
     * @throws Exception
     */
    public function resolveByNameAction($name)
    {
        try {
            return $this->response->setBody(
                $this->serializerWrapper->serialize(
                    $this->candidateAdapter->adaptCandidate(
                        $this->candidateNameResolver->resolveCandidateByName($name)
                    )
                )
            );
        } catch (ExternalServiceException $ex) {
            throw new Exception($ex->getMessage(), 404, $ex);
        }
    }

}
