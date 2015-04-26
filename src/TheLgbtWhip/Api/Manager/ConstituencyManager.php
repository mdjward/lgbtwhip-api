<?php
/**
 * ConstituencyManager.php
 * Definition of class ConstituencyManager
 * 
 * Created 22-Apr-2015 01:13:29
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use TheLgbtWhip\Api\Model\Constituency;
use TheLgbtWhip\Api\Repository\ConstituencyRepository;



/**
 * ConstituencyManager
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ConstituencyManager extends AbstractModelManager
{
    
    /**
     *
     * @var ConstituencyRepository
     */
    protected $constituencyRepository;
    
    
    
    /**
     * 
     * @param ObjectManager $objectManager
     */
    public function __construct(
        ObjectManager $objectManager,
        ConstituencyRepository $constituencyRepository
    ) {
        parent::__construct($objectManager);
        
        $this->constituencyRepository = $constituencyRepository;
    }
    
    /**
     * 
     * @return array
     */
    public function findAll()
    {
        return $this->constituencyRepository->findAll();
    }
    
    /**
     * 
     * @param integer $id
     * @return Constituency|null
     */
    public function findOneById($id)
    {
        return $this->constituencyRepository->find($id);
    }
    
    /**
     * 
     * @param string $name
     * @return Constituency|null
     */
    public function findOneByName($name)
    {
        return $this->constituencyRepository->findOneByName($name);
    }
    
    /**
     * 
     * @param Constituency $constituency
     * @return Constituency
     */
    public function saveConstituency(Constituency $constituency)
    {
        return $this->mergeOrPersistObject($constituency);
    }
    
}
