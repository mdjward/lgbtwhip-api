<?php
namespace TheLgbtWhip\Api\Controller;

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
     * @param CandidateAndPartyManager $candidateAndPartyManager
     * @param ContentTypeSerializerWrapper $serializerWrapper
     */
    public function __construct(
        CandidateAndPartyManager $candidateAndPartyManager,
        ContentTypeSerializerWrapper $serializerWrapper
    ) {
        parent::__construct($serializerWrapper);
        
        $this->candidateAndPartyManager = $candidateAndPartyManager;
    }
    
}
