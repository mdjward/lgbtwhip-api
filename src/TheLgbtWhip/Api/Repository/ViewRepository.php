<?php
/**
 * ViewRepository.php
 * Definition of class ViewRepository
 * 
 * Created 27-Apr-2015 00:43:57
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Repository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Issue;
use TheLgbtWhip\Api\Model\View;



/**
 * ViewRepository
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ViewRepository extends EntityRepository
{
    
    /**
     * 
     * @param Candidate $candidate
     * @param Issue $issue
     * @return View
     */
    public function findOneByIssueAndCandidate(
        Candidate $candidate = null,
        Issue $issue = null
    ) {
        $queryBuilder = $this->createQueryBuilder('vw');
        $expr = $queryBuilder->expr();
        
        return $queryBuilder
            ->where(
                $expr->andX(
                    $expr->eq('vw.candidate', ':candidate'),
                    $expr->eq('vw.issue', ':issue')
                )
            )
            
            ->setParameter(':candidate', $candidate, Type::OBJECT)
            ->setParameter(':issue', $issue, Type::OBJECT)
                
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
