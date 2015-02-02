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

}
