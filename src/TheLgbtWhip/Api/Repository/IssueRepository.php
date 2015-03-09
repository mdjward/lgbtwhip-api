<?php
namespace TheLgbtWhip\Api\Repository;

use Doctrine\ORM\EntityRepository;
use Nette\DateTime;
use TheLgbtWhip\Api\Model\Issue;



/**
 * Description of IssueRepository
 *
 * @author matt
 */
class IssueRepository extends EntityRepository
{
    
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
    
}
