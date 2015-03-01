<?php
/**
 * AbstractController.php
 * Definition of class AbstractController
 * 
 * Created 01-Mar-2015 19:13:42
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Controller;

use Slim\Environment;
use Slim\Http\Request;
use Slim\Http\Response;



/**
 * AbstractController
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
abstract class AbstractController
{
    
    /**
     *
     * @var Request
     */
    protected $request;
    
    /**
     *
     * @var Response
     */
    protected $response;
    
    /**
     *
     * @var Environment
     */
    protected $environment;
    
    
    
    /**
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * 
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * 
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * 
     * @param Request $request
     * @return AbstractController
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        
        return $this;
    }

    /**
     * 
     * @param Response $response
     * @return AbstractController
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        
        return $this;
    }

    /**
     * 
     * @param Environment $environment
     * @return AbstractController
     */
    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;
        
        return $this;
    }

}
