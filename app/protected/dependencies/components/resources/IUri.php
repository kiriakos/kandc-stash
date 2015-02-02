<?php
/**
 *
 * @author kiriakos
 */
interface IUri 
{
    
    public function getUri();
    public function getDomain();
    public function getPort();
    public function getPath();
    public function getQuery();
    public function getQueryElements();
    public function getProtocol();
    
    public function isProtocolSslSecured();
    
    public function setUri($uri);
    public function setDomain($domain);
    public function setPort($port);
    public function setPath($path);
    public function setQuery($query);
    public function setQueryElements($elements);
    public function setProtocol($protocol);
    
}