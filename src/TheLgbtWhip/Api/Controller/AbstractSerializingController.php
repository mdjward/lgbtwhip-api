<?php
/**
 * AbstractSerializingController.php
 * Definition of class AbstractSerializingController
 * 
 * Created 23-Apr-2015 01:09:01
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Controller;

use Slim\Http\Response;
use TheLgbtWhip\Api\Serializer\ContentTypeSerializerWrapper;



/**
 * AbstractSerializingController
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class AbstractSerializingController extends AbstractController
{
    
    /**
     *
     * @var ContentTypeSerializerWrapper
     */
    protected $serializerWrapper;

    
    
    /**
     * 
     * @param ContentTypeSerializerWrapper $serializerWrapper
     */
    public function __construct(ContentTypeSerializerWrapper $serializerWrapper)
    {
        $this->serializerWrapper = $serializerWrapper;
    }
    
    /**
     * 
     * @param Response $response
     * @return AbstractSerializingController
     */
    public function setResponse(Response $response)
    {
        parent::setResponse($response);
        
        $this->setUpResponseHeaders();
        
        return $this;
    }
    
    /**
     * 
     */
    protected function setUpResponseHeaders()
    {
        try {
            if (($format = $this->request->get('format')) !== null) {
                $this->serializerWrapper->setFormat($format);
            }
        } catch (UnexpectedValueException $ex) {
            // Do nothing - proceed to the declaration below
        }
        
        $this->response->headers->set(
            'Content-Type',
            $this->serializerWrapper->getContentTypeFromFormat()
        );
    }
    
}
