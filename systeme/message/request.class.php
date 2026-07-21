<?php
namespace systeme\message;

/**
 *
 * @author Ulysse1976
 *        
 */
class request implements RequestInterface
{

    /**
     */
    public function __construct()
    {}
    
    public function withUri(UriInterface $uri, $preserveHost = false)
    {}

    public function getRequestTarget()
    {}

    public function withRequestTarget($requestTarget)
    {}

    public function withMethod($method)
    {}

    public function getMethod()
    {}

    public function getUri()
    {}

}

