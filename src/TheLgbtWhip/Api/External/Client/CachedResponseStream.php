<?php
/**
 * CachedResponseStream.php
 * Definition of class CachedResponseStream
 * 
 * Created 25-Apr-2015 23:06:17
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client;

use GuzzleHttp\Stream\StreamInterface;



/**
 * CachedResponseStream
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CachedResponseStream implements StreamInterface
{
    
    /**
     *
     * @var string
     */
    protected $data;
    
    /**
     *
     * @var integer
     */
    private $position;
    
    /**
     *
     * @var integer
     */
    private $length;
    
    
    
    /**
     * 
     * @param string $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        
        $this->position = 0;
        $this->length = strlen($data);
    }
    
    /**
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getContents();
    }

    /**
     * 
     */
    public function close()
    {
        return null;
    }

    public function attach($stream)
    {
        throw new BadMethodCallException('Not supported in this implementation');
    }

    public function detach()
    {
        throw new BadMethodCallException('Not supported in this implementation');
    }

    public function eof()
    {
        throw new BadMethodCallException('Not supported in this implementation');
    }

    public function getContents()
    {
        return $this->data;
    }

    public function getMetadata($key = null)
    {
        return null;
    }

    public function getSize()
    {
        return str_length($this->data);
    }

    public function isReadable()
    {
        return true;
    }

    public function isSeekable()
    {
        return false;
    }

    public function isWritable()
    {
        return false;
    }

    public function read($length)
    {
        return $this->data;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        throw new BadMethodCallException('Not supported in this implementation');
    }

    public function tell()
    {
        return $this->position;
    }

    public function write($string)
    {
        throw new BadMethodCallException('Not supported in this implementation');
    }

}
