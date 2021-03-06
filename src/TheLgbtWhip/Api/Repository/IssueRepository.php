<?php
namespace TheLgbtWhip\Api\Repository;

use DateTime;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Issue;



/**
 * Description of IssueRepository
 *
 * @author matt
 */
class IssueRepository extends EntityRepository
{
    
    public function findAll()
    {
        $queryBuilder = $this->createQueryBuilder('i');
        
        return $queryBuilder
            ->orderBy('i.id')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findAllPast()
    {
        $queryBuilder = $this->createQueryBuilder('i');
        
        return $queryBuilder
            ->where($queryBuilder->expr()->isNotNull('i.relevant_act'))
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findAllCurrent()
    {
        $queryBuilder = $this->createQueryBuilder('i');
        
        return $queryBuilder
            ->where($queryBuilder->expr()->isNull('i.relevant_act'))
            ->getQuery()
            ->getResult()
        ;
    }
    
    /**
     * 
     * @param integer $thePublicWhipId
     * @param DateTime $thePublicWhipDate
     * @return Issue|null
     */
    public function findOneByPublicWhipIdentifiers(
        $thePublicWhipId,
        DateTime $thePublicWhipDate
    ) {
        return $this->findOneBy([
            'thePublicWhipId'   =>  $thePublicWhipId,
            'thePublicWhipDate' =>  $thePublicWhipDate
        ]);
    }
    
    /**
     * 
     * @param string $title
     * @return Issue|null
     */
    public function findOneByTitle($title)
    {
        return $this->findOneBy([
            'title' =>  $title
        ]);
    }
    
    /**
     * 
     * @param string $uriKey
     * @return Issue|null
     */
    public function findOneByUriKey($uriKey)
    {
        return $this->findOneBy([
            'uriKey'    =>  $uriKey
        ]);
    }
    
    /**
     * 
     * @param Candidate $candidate
     * @return array
     */
    public function findByCandidate(Candidate $candidate)
    {
        $queryBuilder = $this->createQueryBuilder('i');
        $expr = $queryBuilder->expr();
        
        $queryBuilder
            ->leftJoin(
                'i.votes',
                'vt',
                Join::WITH,
                $expr->eq('vt.candidate', ':candidate')
            )
            ->leftJoin(
                'i.views',
                'vw',
                Join::WITH,
                $expr->eq('vw.candidate', ':candidate')
            )
            ->setParameter(':candidate', $candidate, Type::OBJECT)
            ->orderBy('i.id')
        ;
        
        return $queryBuilder->getQuery()->getResult();
    }
    
}
