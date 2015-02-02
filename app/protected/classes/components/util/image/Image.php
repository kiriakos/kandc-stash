<?php

/**
 * Description of Image file
 *
 * @method IFileIntrospector getFileIntrospector() Dependency
 * @method IFilePublisher    getFilePublisher() Dependency
 * 
 * @author kiriakos
 */
class Image 
extends FileSystemAsset
implements IImage
{
    // directories
    const SAVE_IMAGES_TO_DIRECTORY = '/../images/';
    const SAVE_ORIGINALS_TO_DIRECTORY = '/../images/originals/';
    const SAVE_THUMBNAILS_TO_DIRECTORY = '/../thumbnails/';
    const SYSTEM_IMAGES_DIRECTORY = '/../images/system/';
    
    const SAVED_IMAGES_DIRECTORY = '/images/';
    const SAVED_ORIGINALS_DIRECTORY = '/images/originals/';
    const SAVED_THUMBNAILS_DIRECTORY = '/thumbnails/';
    const SYSTEM_IMAGES_PATH = '/images/system/';
    
    const SYSTEM_NO_THUMBNAIL_FILENAME = 'no-thumbnail.png';
    const SYSTEM_NO_IMAGE_FILENAME = 'no-image.png';
    
    //image properties
    const QUADRATIC_THUMBNAIL_SIDE = 96;
    const WIDE_THUMBNAIL_WIDTH = 202; // 2*96+10
    const WIDE_THUMBNAIL_HEIGHT = 96;
    
    const DEFAULT_THUMBNAIL_WIDTH = 300; // 2*96+10
    const DEFAULT_THUMBNAIL_HEIGHT = 400;
    
    const JPEG_QUALITY = 95;
    const PNG_QUALITY = 9; //9 compression
    const SYSTEM_DEFAULT_THUMBNAIL_IS_QUADRATIC = True;
    
    //display properties
    const UPDATE_WIDTH = '700';
    const MAIN_APP_WIDTH = '500';
    
    //suported image types
    const SUPPORTED_TYPES = 'jpg, png, jpeg';
    
    public function getFileName() {
        return array_pop(explode(DIRECTORY_SEPARATOR, $this->getPath()));
    }

    public function getImageDir($width) {
        return APP_ROOT . "/images/" . $width;
    }

    public function getImagePath($width) {
        return $this->getImageDir($width) 
                . str_replace(APP_ROOT, "",$this->getPath());;
    }

    public function getOriginalDir() {
        return join(DIRECTORY_SEPARATOR, array_slice(
                explode(DIRECTORY_SEPARATOR, $this->getPath()), -1));
    }

    public function getOriginalPath() {
        return $this->getPath();
    }

    public function getThumbnailDir($width, $height) {
        return APP_ROOT . "/thumbnails/" . $width . "_". $height;
    }
    
    public function getThumbnailPath($width, $height) {
        return $this->getThumbnailDir($width, $height) 
                . str_replace(APP_ROOT, "",$this->getPath());
    }

    public function getFileExtension()
    {
        return array_pop(explode(".", $this->getOriginalPath()));
    }
}
