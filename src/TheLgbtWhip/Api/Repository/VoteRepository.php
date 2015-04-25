<?php
/**
 * VoteRepository.php
 * Definition of class VoteRepository
 * 
 * Created 24-Apr-2015 16:12:38
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Repository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Issue;



/**
 * VoteRepository
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class VoteRepository extends EntityRepository
{
    
    /**
     * 
     * @param Candidate $candidate
     * @param Issue $issue
     * @return Vote|null
     */
    public function findOneByCandidateAndIssue(
        Candidate $candidate = null,
        Issue $issue = null
    ) {
        $queryBuilder = $this->createQueryBuilder('v');
        $expr = $queryBuilder->expr();
        
        return $queryBuilder
            ->join('v.candidate', 'c')
            ->join('v.issue', 'i')
            ->where(
                $expr->andX(
                    $expr->eq('v.candidate', ':candidate'),
                    $expr->eq('v.issue', ':issue')
                )
            )
                
            ->setParameter('candidate', $candidate, Type::OBJECT)
            ->setParameter('issue', $issue, Type::OBJECT)
            
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
