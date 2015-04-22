<?php
/**
 * ContentTypeSerializerWrapper.php
 * Definition of class ContentTypeSerializerWrapper
 * 
 * Created 22-Apr-2015 23:12:51
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Serializer;

use InvalidArgumentException;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use UnexpectedValueException;



/**
 * ContentTypeSerializerWrapper
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ContentTypeSerializerWrapper
{
    
    /**
     *
     * @var SerializerInterface
     */
    protected $serializer;
    
    /**
     *
     * @var string
     */
    protected $format;
    
    
    
    /**
     * 
     * @param SerializerInterface $serializer
     * @param string $contentType
     */
    public function __construct(
        SerializerInterface $serializer,
        $contentType
    ) {
        $this->serializer = $serializer;
        
        $this->setFormatFromContentType($contentType);
    }
    
    /**
     * 
     * @param string $contentType
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function setFormatFromContentType($contentType)
    {
        if (!is_string($contentType)) {
            throw new InvalidArgumentException(
                'Content type must be given as a string'
            );
        }
        
        $matches = [];
        if (preg_match("#^\s*(?:[^\/]+)\/([a-z0-9]+)#i", $contentType, $matches)) {
            try {
                $this->setFormat($matches[1]);
            } catch (UnexpectedValueException $ex) {
                $this->setFormat('json');
            }
            
            return $this;
        }
        
        throw new UnexpectedValueException(
            "Invalid content type specification '{$contentType}'"
        );
    }
    
    /**
     * 
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }
    
    /**
     * 
     * @param string $format
     * @return UnexpectedValueException|ContentTypeSerializerWrapper
     */
    public function setFormat($format)
    {
        switch (($format = strtolower($format))) {
            case 'xml':
            case 'yml':
            case 'json':
                $this->format = $format;
                
                return $this;
        }
        
        throw new UnexpectedValueException("Unrecognised format '{$format}'");
    }

    /**
     * 
     * @return string
     */
    public function getContentTypeFromFormat()
    {
        return 'application/' . $this->getFormat();
    }

    /**
     * 
     * @param object $data
     * @param SerializationContext $context
     * @return string
     */
    public function serialize($data, SerializationContext $context = null)
    {
        return $this->serializer->serialize(
            $data,
            $this->format,
            $context
        );
    }

    /**
     * 
     * @param string $data
     * @param string $type
     * @param SerializationContext $context
     * @return object
     */
    public function deserialize($data, $type, SerializationContext $context = null)
    {
        return $this->serializer->deserialize(
            $data,
            $type,
            $this->format,
            $context
        );
    }

}
