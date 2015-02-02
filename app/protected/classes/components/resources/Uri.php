<?php
/**
 * OO interface to a Uri
 * 
 * Allows for formal getting and setting of URI parameters.
 *
 * @author kiriakos
 */
class Uri 
extends Component
implements IUri
{
    private $_uri = NULL;
    
    public function getDomain() {
        throw new Exception("Not implemented!");
    }

    public function getPath() {
        throw new Exception("Not implemented!");
    }

    public function getPort() {
        throw new Exception("Not implemented!");
    }

    public function getProtocol() {
        throw new Exception("Not implemented!");
    }

    public function getQuery() {
        throw new Exception("Not implemented!");
    }

    public function getQueryElements() {
        throw new Exception("Not implemented!");
    }

    public function getUri() {
        return $this->_uri;
    }

    public function isProtocolSslSecured() {
        throw new Exception("Not implemented!");
    }

    public function setDomain($domain) {
        throw new Exception("Not implemented!");
    }

    public function setPath($path) {
        throw new Exception("Not implemented!");
    }

    public function setPort($port) {
        throw new Exception("Not implemented!");
    }

    public function setProtocol($protocol) {
        throw new Exception("Not implemented!");
    }

    public function setQuery($query) {
        throw new Exception("Not implemented!");
    }

    public function setQueryElements($elements) {
        throw new Exception("Not implemented!");
    }

    public function setUri($uri) {
        $this->_uri = $uri;
    }
}
