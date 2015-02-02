<?php
/**
 *
 * @author kiriakos
 */
interface IImageResizer {
    
    /**
     * Create a resized Image based on width
     * 
     * @param \IImage $image
     * @param integer $target_width
     */
    public function createImage(\IImage $image, $target_width);
    
    /**
     * Resiye an image
     */
    public function resizeImage($original_path, $target_path, $target_width, 
                $target_height);
    /**
     * Create a croped version of an Image
     * 
     * @param \IImage $image
     * @param type $width
     * @param type $height
     * @param type $coords
     * @param type $rescale
     */
    public function createCrop(\IImage $image, $width, $height, $coords, $rescale);
}
