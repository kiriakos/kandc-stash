<?php
/**
 * A simplistic implementation of request
 *
 * @author kiriakos
 */
class Request 
extends Component
implements IRequest
{
    public function getCookie() 
    {
    }

    public function getParameter($name, $filter = FILTER_UNSAFE_RAW) 
    {
        switch($this->getVerb())
        {
            case 'post':
                $input = INPUT_POST;
                break;
            case 'get':
                $input = INPUT_GET;
                break;
            case 'put':
                $input = INPUT_REQUEST;
                break;
            case 'head':
                $input = INPUT_GET;
                break;
            case 'delete':
                $input = INPUT_GET;
                break;
        }
        
        return filter_input($input, $name, $filter);
    }

    public function getSchema() 
    {
        return preg_filter('#/.*#', '', filter_input(INPUT_SERVER, 
                'SERVER_PROTOCOL'));
    }

    public function getVerb() 
    {
        return strtolower(filter_input(INPUT_SERVER, 'REQUEST_METHOD'));
    }

    public function hasParameter($name) 
    {
        return ($this->getParameter($name) !== NULL);
    }

    public function getParameterOr($name, $or_value, 
            $filter = FILTER_UNSAFE_RAW) 
    {
        if($this->hasParameter($name))
        {
            return $this->getParameter($name, $filter);
        }
        else
        {
            return $or_value;
        }
    }

    public function getRequestPath()
    {
        $query = $this->getServer("QUERY_STRING");
        $escaped_query = str_replace("/", "\/", $query);
        $filter = "/\??" . $escaped_query . "$/";
        return preg_filter($filter, "", $this->getServer("REQUEST_URI"));
    }
    
    public function getRequestUri() {
        return $this->getServer("REQUEST_URI");
    }

    public function getScriptName() {
        return $this->getServer("SCRIPT_NAME");
    }

    /**
     * Wrapper for filter_input SERVER
     * 
     * @param string $property
     * @return mixed
     */
    public function getServer($property) 
    {
        return filter_input(INPUT_SERVER, $property);
    }

    public function getFile($name) 
    {
        if(!isset($_FILES[$name])){
            throw new BadMethodCallException("No uploaded file named: $name !");
        }
        
        $file = $_FILES[$name];
        
        if($file["error"] == 1){
            throw new Exception("This file had an error. Have You uploaded a"
                    . " file that was too big for Your setup? please validate"
                    . " by checking php.ini's 'upload_max_filesize' and"
                    . " 'post_max_size'.");
        }
        
        return $_FILES[$name];
    }

}
