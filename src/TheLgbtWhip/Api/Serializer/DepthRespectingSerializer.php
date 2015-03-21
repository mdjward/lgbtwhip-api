<?php
/**
 * DepthRespectingSerializer.php
 * Definition of class DepthRespectingSerializer
 * 
 * Created 18-Mar-2015 19:37:39
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Serializer;

use InvalidArgumentException;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;



/**
 * DepthRespectingSerializer
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class DepthRespectingSerializer implements SerializerInterface
{
    
    /**
     *
     * @var SerializerInterface 
     */
    protected $realSerializer;
    
    
    
    /**
     * 
     * @param SerializerInterface $realSerializer
     * @throws InvalidArgumentException
     */
    public function __construct(SerializerInterface $realSerializer)
    {
        $this->setRealSerializer($realSerializer);
    }
    
    /**
     * 
     * @param SerializerInterface $realSerializer
     * @return DepthRespectingSerializer
     * @throws InvalidArgumentException
     */
    public function setRealSerializer(SerializerInterface $realSerializer)
    {
        if ($realSerializer === $this) {
            throw new InvalidArgumentException(
                'Cannot pass this object as the wrapped serializer'
            );
        }
        
        $this->realSerializer = $realSerializer;
        
        return $this;
    }
    
    public function serialize(
        $data,
        $format,
        SerializationContext $context = null
    ) {
        return $this->realSerializer->serialize(
            $data,
            $format,
            ($context ?: $this->createSerializationContext())
        );
    }
    
    public function deserialize(
        $data,
        $type,
        $format,
        DeserializationContext $context = null
    ) {
        return $this->realSerializer->serialize(
            $data,
            $type,
            $format,
            ($context ?: $this->createSerializationContext())
        );
    }
    
    protected function createSerializationContext()
    {
        $context = new SerializationContext();
        
        return $context->enableMaxDepthChecks();
    }
    
}
