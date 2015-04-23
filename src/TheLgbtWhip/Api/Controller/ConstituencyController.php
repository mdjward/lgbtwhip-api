<?php
/**
 * ConstituencyController.php
 * Definition of class ConstituencyController
 *
 * Created 01-Mar-2015 13:28:18
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Controller;

use TheLgbtWhip\Api\External\ConstituencyIdResolverInterface;
use TheLgbtWhip\Api\External\ConstituencyNameResolverInterface;
use TheLgbtWhip\Api\External\PostcodeToConstituencyMappingInterface;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Repository\ConstituencyRepository;
use TheLgbtWhip\Api\Serializer\ContentTypeSerializerWrapper;



/**
 * ConstituencyController
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ConstituencyController extends AbstractSerializingController
{

    /**
     *
     * @var PostcodeToConstituencyMappingInterface
     */
    private $postcodeToConstituencyMapper;

    /**
     *
     * @var ConstituencyIdResolverInterface 
     */
    private $constituencyIdResolver;
    
    /**
     *
     * @var ConstituencyNameResolverInterface 
     */
    private $constituencyNameResolver;
    
    /**
     * @var ConstituencyRepository
     */
    private $constituencyRepository;
    


    /**
     * 
     * @param PostcodeToConstituencyMappingInterface $postcodeToConstituencyMapper
     * @param ConstituencyIdResolverInterface $constituencyIdResolver
     * @param ConstituencyNameResolverInterface $constituencyNameResolver
     * @param ConstituencyRepository $constituencyRepository
     * @param ContentTypeSerializerWrapper $serializerWrapper
     */
    public function __construct(
        PostcodeToConstituencyMappingInterface $postcodeToConstituencyMapper,
        ConstituencyIdResolverInterface $constituencyIdResolver,
        ConstituencyNameResolverInterface $constituencyNameResolver,
        ConstituencyRepository $constituencyRepository,
        ContentTypeSerializerWrapper $serializerWrapper
    ) {
        parent::__construct($serializerWrapper);
        
        $this->postcodeToConstituencyMapper = $postcodeToConstituencyMapper;
        $this->constituencyIdResolver = $constituencyIdResolver;
        $this->constituencyNameResolver = $constituencyNameResolver;
        
        $this->constituencyRepository = $constituencyRepository;
    }
    
    /**
     * @param string $givenPostcode
     * @return Constituency
     */
    public function resolveByPostcodeAction($givenPostcode)
    {
        return $this->response->setBody(
            $this->serializerWrapper->serialize(
                $this->postcodeToConstituencyMapper->getConstituencyFromPostcode($givenPostcode)
            )
        );
    }
    
    public function resolveByIdAction($id)
    {
        return $this->response->setBody(
            $this->serializerWrapper->serialize(
                $this->constituencyIdResolver->resolveConstituencyById($id)
            )
        );
    }

    public function resolveByNameAction($name)
    {
        return $this->response->setBody(
            $this->serializerWrapper->serialize(
                $this->constituencyNameResolver->resolveConstituencyByName($name)
            )
        );
    }

}
