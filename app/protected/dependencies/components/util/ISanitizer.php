<?php
/**
 * A generic Sanitization facility
 *
 * @author kiriakos
 */
interface ISanitizer 
{    
    public function sanitize($dirty, $parametrizer = NULL);
}
