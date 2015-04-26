<?php
/**
 * AbstractCandidateLoader.php
 * Definition of class AbstractCandidateLoader
 * 
 * Created 26-Apr-2015 12:32:59
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Loader;

use TheLgbtWhip\Api\External\CandidateIdResolverInterface;
use TheLgbtWhip\Api\External\CandidateIssueVoteCheckerInterface;
use TheLgbtWhip\Api\External\CandidateNameResolverInterface;
use TheLgbtWhip\Api\External\CandidateNameSearcherInterface;
use TheLgbtWhip\Api\External\ConstituencyCandidatesRetrieverInterface;
use TheLgbtWhip\Api\External\PastMpTermRetrieverInterface;



/**
 * AbstractCandidateLoader
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
abstract class AbstractCandidateLoader
    implements
        CandidateIdResolverInterface,
        CandidateNameResolverInterface,
        ConstituencyCandidatesRetrieverInterface
{
    
    /**
     *
     * @var CandidateIdResolverInterface
     */
    protected $candidateIdResolver;
    
    /**
     *
     * @var CandidateNameResolverInterface
     */
    protected $candidateNameResolver;
    
    /**
     *
     * @var CandidateNameSearcherInterface
     */
    protected $candidateNameSearcher;
    
    /**
     *
     * @var ConstituencyCandidatesRetrieverInterface
     */
    protected $constituencyCandidatesRetriever;
    
    /**
     *
     * @var CandidateIssueVoteCheckerInterface
     */
    protected $candidateIssueVoteChecker;
    
    /**
     * 
     * @var PastMpTermRetrieverInterface
     */
    protected $pastMpTermsRetriever;
    
    
    
    /**
     * 
     * @param CandidateIdResolverInterface $candidateIdResolver
     * @param CandidateNameResolverInterface $candidateNameResolver
     * @param CandidateNameSearcherInterface $candidateNameSearcher
     * @param ConstituencyCandidatesRetrieverInterface $constituencyCandidatesRetriever
     * @param CandidateIssueVoteCheckerInterface $candidateIssueVoteChecker
     * @param PastMpTermRetrieverInterface $pastMpTermsRetriever
     */
    public function __construct(
        CandidateIdResolverInterface $candidateIdResolver,
        CandidateNameResolverInterface $candidateNameResolver,
        CandidateNameSearcherInterface $candidateNameSearcher,
        ConstituencyCandidatesRetrieverInterface $constituencyCandidatesRetriever,
        CandidateIssueVoteCheckerInterface $candidateIssueVoteChecker,
        PastMpTermRetrieverInterface $pastMpTermsRetriever
    ) {
        $this->candidateIdResolver = $candidateIdResolver;
        $this->candidateNameResolver = $candidateNameResolver;
        $this->candidateNameSearcher = $candidateNameSearcher;
        $this->constituencyCandidatesRetriever = $constituencyCandidatesRetriever;
        $this->candidateIssueVoteChecker = $candidateIssueVoteChecker;
        $this->pastMpTermsRetriever = $pastMpTermsRetriever;
    }
    
}
