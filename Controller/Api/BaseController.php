<?php
class BaseController
{
    /**
     * __call magic method.
     * 
     * The __call method is a magic method,
     * and it’s called when you try to call a method that doesn't exist
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
        // throw the HTTP/1.1 404 Not Found error when someone tries to call a method which we haven’t implemented
    }
 
    /**
     * Get URI elements.
     * 
     *  returns an array of URI segments.
     *  It’s useful when we try to validate the REST endpoint called by the user
     * @return array
     */
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
 
        return $uri;
    }
 
    /**
     * Get querystring params.
     * 
     * @return array
     */
    protected function getQueryStringParams()
    {
        return parse_str($_SERVER['QUERY_STRING'], $query);
        // convert string to variable => name=ahmad&id=2
        // returns an array of query string variables that are passed along with the incoming request.
    }
 
    /**
     * Send API output.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
 
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
 
        echo $data;
        exit;
    }
}