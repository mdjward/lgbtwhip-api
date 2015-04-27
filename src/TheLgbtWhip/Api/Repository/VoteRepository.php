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
use Doctrine\ORM\Query\Expr\Join;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Issue;
use TheLgbtWhip\Api\Model\Vote;



/**
 * VoteRepository
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class VoteRepository extends EntityRepository
{
    
    /**
     * 
     * @param Issue $issue
     * @return array
     */
    public function findByIssue(Issue $issue)
    {
        $queryBuilder = $this->createQueryBuilder('v');
        
        return $queryBuilder
            ->where($queryBuilder->expr()->eq('v.issue', ':issue'))
            
            ->setParameter(':issue', $issue, Type::OBJECT)
            
            ->getQuery()
            ->getResult()
        ;
    }
    
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
            ->join(
                'v.candidate',
                'c',
                Join::WITH,
                $expr->eq('c.id', ':candidateId')
            )
            ->join(
                'v.issue',
                'i',
                Join::WITH,
                $expr->eq('i.id', ':issueId')
            )

            ->setParameter(':candidateId', $candidate->getId(), Type::INTEGER)
            ->setParameter(':issueId', $issue->getId(), Type::INTEGER)

            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
