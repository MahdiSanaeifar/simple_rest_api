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
        // $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
        $this->sendOutput(json_encode(array('error' => 'Action Not Found!')), 
                array('Content-Type: application/json', 'HTTP/1.1 404 Not Found')
        );
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
        // return array(4) { [0]=> string(0) "" [1]=> string(9) "index.php" [2]=> string(4) "user" [3]=> string(4) "list" } 
    }
 
    /**
     * Get querystring params.
     * 
     * @return array
     */
    public function getQueryStringParams()
    {
        return $_REQUEST;
        // return parse_str($_SERVER['QUERY_STRING'], $query);
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