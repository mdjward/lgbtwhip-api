<?php
/**
 * AbstractModelManager.php
 * Definition of class AbstractModelManager
 * 
 * Created 20-Apr-2015 18:21:04
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use InvalidArgumentException;



/**
 * AbstractModelManager
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
abstract class AbstractModelManager
{
    
    /**
     *
     * @var ObjectManager
     */
    protected $objectManager;
    
    
    
    /**
     * 
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }
    
    /**
     * 
     * @return ObjectManager
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }
    
    /**
     * 
     * @param object $object
     * @return object
     * @throws InvalidArgumentException
     */
    protected function mergeOrPersistObject($object)
    {
        if (!is_object($object)) {
            throw new InvalidArgumentException('Unable to merge/persist a non-object');
        }
        
        try {
            $managedObject = $this->objectManager->merge($object);
        } catch (EntityNotFoundException $ex) {
            $this->objectManager->persist(($managedObject = $object));
        }
        
        $this->objectManager->flush($managedObject);
        
        return $managedObject;
    }
    
}
