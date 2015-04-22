<?php
/**
 * MapItPersistingProcessor.php
 * Definition of class MapItPersistingProcessor
 * 
 * Created 22-Apr-2015 01:11:18
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client\MapIt;

use GuzzleHttp\Message\ResponseInterface;
use TheLgbtWhip\Api\External\ConstituencyCandidatesRetrieverInterface;
use TheLgbtWhip\Api\Manager\ConstituencyManager;
use TheLgbtWhip\Api\Model\Constituency;



/**
 * MapItPersistingProcessor
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class MapItPersistingProcessor extends MapItProcessor
{
    
    /**
     *
     * @var ConstituencyManager
     */
    protected $constituencyManager;
    
    
    
    /**
     * 
     * @param ConstituencyManager $constituencyManager
     */
    public function __construct(
        ConstituencyCandidatesRetrieverInterface $constituencyCandidateRetriever,
        ConstituencyManager $constituencyManager
    ) {
        parent::__construct($constituencyCandidateRetriever);
        
        $this->constituencyManager = $constituencyManager;
    }
    
    /**
     * 
     * @param ResponseInterface $response
     * @return Constituency
     */
    protected function buildConstituencyFromResponse(ResponseInterface $response)
    {
        return $this->constituencyManager->saveConstituency(
            parent::buildConstituencyFromResponse($response)
        );
    }
    
}
