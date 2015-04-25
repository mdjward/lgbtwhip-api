<?php
namespace TheLgbtWhip\Api\Repository;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityRepository;
use TheLgbtWhip\Api\Model\Candidate;
use TheLgbtWhip\Api\Model\Constituency;



/**
 * Description of CandidateRepository
 *
 * @author matt
 */
class CandidateRepository extends EntityRepository
{
    
    /**
     * 
     * @param string $name
     * @return Candidate|null
     */
    public function findOneByName($name)
    {
        return $this->findOneBy([
            'name' => $name
        ]);
    }
    
    /**
     * 
     * @param string $name
     * @param Constituency $constituency
     * @return Candidate
     */
    public function findOneByNameAndConstituency($name, Constituency $constituency)
    {
        $queryBuilder = $this->createQueryBuilder('c');
        $expr = $queryBuilder->expr();
        
        return $queryBuilder
            ->where(
                $expr->and(
                    $expr->eq('name'),
                    $expr->eq('c.constituency', ':constituency')
                )
            )
            
            ->setParameter(':constituency', $constituency, Type::OBJECT)
            
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
