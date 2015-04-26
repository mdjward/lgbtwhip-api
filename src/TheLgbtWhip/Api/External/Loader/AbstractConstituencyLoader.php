<?php
/**
 * AbstractConstituencyLoader.php
 * Definition of class AbstractConstituencyLoader
 * 
 * Created 26-Apr-2015 12:32:28
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Loader;

use TheLgbtWhip\Api\External\AllConstituenciesRetrieverInterface;
use TheLgbtWhip\Api\External\ConstituencyCandidatesRetrieverInterface;
use TheLgbtWhip\Api\External\ConstituencyIdResolverInterface;
use TheLgbtWhip\Api\External\ConstituencyNameResolverInterface;
use TheLgbtWhip\Api\External\PostcodeToConstituencyMappingInterface;



/**
 * AbstractConstituencyLoader
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
abstract class AbstractConstituencyLoader
    implements
        AllConstituenciesRetrieverInterface,
        ConstituencyNameResolverInterface,
        ConstituencyIdResolverInterface,
        PostcodeToConstituencyMappingInterface
{
    
    /**
     *
     * @var AllConstituenciesRetrieverInterface
     */
    protected $allConstituenciesRetriever;
    
    /**
     *
     * @var PostcodeToConstituencyMappingInterface
     */
    protected $postcodeConstituencyMapper;
    
    /**
     *
     * @var ConstituencyIdResolverInterface
     */
    protected $constituencyIdResolver;
    
    /**
     *
     * @var ConstituencyNameResolverInterface
     */
    protected $constituencyNameResolver;
    
    /**
     *
     * @var ConstituencyCandidatesRetrieverInterface
     */
    protected $constituencyCandidatesRetriever;
    
    
    
    /**
     * 
     * @param AllConstituenciesRetrieverInterface $allConstituenciesRetriever
     * @param PostcodeToConstituencyMappingInterface $postcodeConstituencyMapper
     * @param ConstituencyIdResolverInterface $constituencyIdResolver
     * @param ConstituencyNameResolverInterface $constituencyNameResolver
     * @param ConstituencyCandidatesRetrieverInterface $constituencyCandidatesRetriever
     */
    public function __construct(
        AllConstituenciesRetrieverInterface $allConstituenciesRetriever,
        PostcodeToConstituencyMappingInterface $postcodeConstituencyMapper,
        ConstituencyIdResolverInterface $constituencyIdResolver,
        ConstituencyNameResolverInterface $constituencyNameResolver,
        ConstituencyCandidatesRetrieverInterface $constituencyCandidatesRetriever
    ) {
        $this->allConstituenciesRetriever = $allConstituenciesRetriever;
        $this->postcodeConstituencyMapper = $postcodeConstituencyMapper;
        $this->constituencyIdResolver = $constituencyIdResolver;
        $this->constituencyNameResolver = $constituencyNameResolver;
        $this->constituencyCandidatesRetriever = $constituencyCandidatesRetriever;
    }
    
}
