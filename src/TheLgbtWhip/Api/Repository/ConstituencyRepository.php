<?php
/**
 * ConstituencyRepository.php
 * Definition of class ConstituencyRepository
 * 
 * Created 01-Mar-2015 17:41:42
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Repository;

use Doctrine\ORM\EntityRepository;



/**
 * ConstituencyRepository
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ConstituencyRepository extends EntityRepository
{
    
    /**
     * 
     * @param string $name
     * @return Constituency|null
     */
    public function findOneByName($name)
    {
        return $this->findOneBy([
            'name' => $name
        ]);
    }
    
}
