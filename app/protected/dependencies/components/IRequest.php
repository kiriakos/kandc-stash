<?php
/**
 *
 * @author kiriakos
 */
interface IRequest 
{
    /**
     * Check whether a request parameter exists
     * 
     * @param string $name
     */
    function hasParameter($name);
    
    /**
     * Applies filter input searching for a specific parameter
     * 
     * @param string $name
     * @param integer $filter
     */
    function getParameter($name, $filter = FILTER_UNSAFE_RAW);

    /**
     * @return mixed
     */
    function getServer($property);
    function getRequestUri();
    function getRequestPath();
    function getScriptName();
    
    
    /**
     * Get a request parameter or default to the or value
     * 
     * @param string $name
     * @param integer $filter
     * @param mixed $or_value
     */
    function getParameterOr($name, $or_value, $filter);
    function getSchema();
    function getVerb();
    function getCookie();
    
    /**
     * Get an entry of the $_FILE array
     * @param string $name
     */
    function getFile($name);
}
