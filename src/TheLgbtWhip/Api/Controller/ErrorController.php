<?php
/**
 * ErrorController.php
 * Definition of class ErrorController
 * 
 * Created 20-Apr-2015 18:35:55
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Controller;

use Exception;
use TheLgbtWhip\Api\Serializer\ContentTypeSerializerWrapper;



/**
 * ErrorController
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class ErrorController extends AbstractSerializingController
{
    
    /**
     * 
     * @param ContentTypeSerializerWrapper $serializerWrapper
     */
    public function __construct(ContentTypeSerializerWrapper $serializerWrapper)
    {
        $this->serializerWrapper = $serializerWrapper;
    }
    
    public function error401Action()
    {
        return $this->errorAction(
            401,
            'Bad request'
        );
    }
    
    public function error403Action()
    {
        return $this->errorAction(
            403,
            'Access denied'
        );
    }
    
    public function error404Action()
    {
        return $this->errorAction(
            404,
            'Unrecognised endpoint ' . $this->request->getPath()
        );
    }
    
    public function errorAction(
        $statusCode,
        $message = null
    ) {
        return $this->exceptionAction(
            new Exception($message, $statusCode)
        );
    }
    
    public function exceptionAction(Exception $ex)
    {
        $this->response->setStatus($ex->getCode());
        
        return print $this->serializerWrapper->serialize($ex);
    }
    
}
