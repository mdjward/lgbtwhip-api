<?php
/**
 * ImageResponseWrapper.php
 * Definition of class ImageResponseWrapper
 * 
 * Created 28-Apr-2015 19:52:49
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Image;



/**
 * ImageResponseWrapper
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ImageResponseWrapper
{
    
    /**
     *
     * @var string
     */
    protected $imageType;
    
    /**
     *
     * @var mixed
     */
    protected $imageData;
    
    
    
    /**
     * 
     * @param string|null $imageType
     * @param mixed|null $imageData
     */
    public function __construct($imageType = null, $imageData = null)
    {
        $this
            ->setImageType($imageType)
            ->setImageData($imageData)
        ;
    }
    
    /**
     * 
     * @return string
     */
    public function getImageType()
    {
        return $this->imageType;
    }

    /**
     * 
     * @return mixed
     */
    public function getImageData()
    {
        return $this->imageData;
    }

    /**
     * 
     * @param string $imageType
     * @return ImageResponseWrapper
     */
    public function setImageType($imageType)
    {
        $this->imageType = $imageType;
        
        return $this;
    }

    /**
     * 
     * @param string $imageData
     * @return ImageResponseWrapper
     */
    public function setImageData($imageData)
    {
        $this->imageData = $imageData;
        
        return $this;
    }
    
}
