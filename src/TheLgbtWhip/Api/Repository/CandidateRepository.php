<?php
namespace TheLgbtWhip\Api\Repository;

use Doctrine\ORM\EntityRepository;



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
    
}
