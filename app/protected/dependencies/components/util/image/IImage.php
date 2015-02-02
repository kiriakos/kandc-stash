<?php
/**
 * Represents an image file
 *
 * @author kiriakos
 */
interface IImage 
{
    public function getFileName();
    
    public function getOriginalPath();
    public function getOriginalDir();
    
    public function getImageDir($width);
    public function getImagePath($width);
    
    public function getThumbnailPath($width,$height);
    public function getThumbnailDir($width,$height);
}
