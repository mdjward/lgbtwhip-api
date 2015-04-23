<?php
namespace TheLgbtWhip\Api\Controller;

use TheLgbtWhip\Api\External\CandidateIdResolverInterface;
use TheLgbtWhip\Api\External\CandidateNameResolverInterface;
use TheLgbtWhip\Api\Manager\CandidateAndPartyManager;
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
     * @param CandidateAndPartyManager $candidateAndPartyManager
     * @param CandidateIdResolverInterface $candidateIdResolver
     * @param CandidateNameResolverInterface $candidateNameResolver
     * @param ContentTypeSerializerWrapper $serializerWrapper
     */
    public function __construct(
        CandidateAndPartyManager $candidateAndPartyManager,
        CandidateIdResolverInterface $candidateIdResolver,
        CandidateNameResolverInterface $candidateNameResolver,
        ContentTypeSerializerWrapper $serializerWrapper
    ) {
        parent::__construct($serializerWrapper);
        
        $this->candidateAndPartyManager = $candidateAndPartyManager;
        $this->candidateIdResolver = $candidateIdResolver;
        $this->candidateNameResolver = $candidateNameResolver;
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
                    $this->candidateIdResolver->resolveCandidateById($id)
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
                    $this->candidateNameResolver->resolveCandidateByName($name)
                )
            );
        } catch (ExternalServiceException $ex) {
            throw new Exception($ex->getMessage(), 404, $ex);
        }
    }

}
