<?php
/**
 * Description of EditablePixelsBehavior
 *
 * @author kiriakos
 */
class ImageResizer
extends Component
implements IImageResizer
{
    /**
     *  Generates the images thumbnail filename according to it's dimensions
     *
     * eg:
     *  96-a34kfNsindr3Ts21.png         <-- quadratic 96px
     *  128X256-a34kfNsindr3Ts21.jpg    <-- rect w128 h256
     *
     * the algo does check the passed dimensions for equality, so even if you
     * ask for 128x128-... filenam it will generate 128-asdf.jkpg
     *
     * @param string $filename
     * @return string false
     */
    public function getThumbnailName($filename=NULL,$width = null,$height = null)
    {

        if($width) $width = (int)$width;
        if($height) $height = (int)$height;

        //override $this->filename if $filename requested
        if ($filename === NULL && isset($this->file_name))
                $filename =  $this->file_name;
        //if none of the two exist return false
        elseif ($filename === NULL) 
                return false;

        $dims = Image::QUADRATIC_THUMBNAIL_SIDE;

        //swap for width and generate quadratic name if both dims are equal
        if (!$width && $height) $width = $height;
        if ($width && $width == $height ) $height = null;

        if ($width && $height)
            $dims = $width.'x'.$height;
        elseif ($width && !$height)
            $dims = $width;

        //return the name based on the requested $filename
        return $dims.'-'.$filename;
    }

    /**
     * Create an imagespace
     * 
     * @param string $file
     * @return resource
     */
    private function createImagicImageSpace($file)
    {
        $file_type = pathinfo($file, PATHINFO_EXTENSION);

        if ($file_type == 'jpg' || $file_type == 'jpeg') {
                return imagecreatefromjpeg($file);
        }
        elseif ($file_type == 'png') {
                return imagecreatefrompng($file);
        }
        elseif ($file_type == 'gif') {
                return imagecreatefromgif($file);
        }
        else {
                return false;
        }
    }

    /**
     * Creates a new image based on an existing path
     * 
     * creates a
     * 
     * @param string $original_path
     * @param string $target_path
     * @param integer $target_width
     * @param integer $target_height
     * @return string
     * @throws Exception
     */
    public function resizeImage($original_path, $target_path, $target_width, 
            $target_height)
    {
        $file_type = pathinfo($original_path, PATHINFO_EXTENSION);
        $original_image_space = $this->createImagicImageSpace(
                $original_path);

        $target_image_space = imagecreatetruecolor($target_width, 
                $target_height);
        
        if ($file_type == 'png' || $file_type == 'gif')
        {
            imagealphablending($target_image_space, false);
            imagesavealpha($target_image_space,true);
            $transparent = imagecolorallocatealpha($target_image_space, 255,
                    255, 255, 127);
            imagefilledrectangle($target_image_space, 0, 0, $target_width,
                    imagesy($original_image_space)/$origW2optW, $transparent);
        }

        if(!imagecopyresampled($target_image_space, $original_image_space,
                0,0,0,0,
                imagesx($target_image_space), imagesy($target_image_space),
                imagesx($original_image_space), 
                imagesy($original_image_space)
                ))
        {
            throw new Exception("Could not copy data into the image"
                    . " space!");
        }

        //return succes
        if ($this->saveImage($file_type, $target_image_space, $target_path))
        {
           return $target_path;
        }
        else
        {
            throw new Exception("Could not resize the image!!");
        }
    }

    /**
     * 
     * @param string $file_type
     * @param string $target_image_space
     * @param string $target_path
     */
    private function saveImage($file_type, $target_image_space, $target_path)
    {
        $saved = FALSE;

        if ($file_type == 'jpg' || $file_type == 'jpeg') {
                $saved = imagejpeg($target_image_space, $target_path, 
                        Image::JPEG_QUALITY);
        }
        elseif ($file_type == 'png') {
                $saved = imagepng($target_image_space, $target_path, 
                        Image::PNG_QUALITY);
        }
        elseif ($file_type == 'gif') {
                $saved = imagegif($target_image_space, $target_path);
        }

        return $saved;
    }

    /**
     *  Create an image file in images/int/filename
     *
     * Because the user will be uploading arbitrary size bitmaps the app
     * has to optimize (shrink) the images to the size they need
     *
     * @param IImage $image
     * @return string           The path where the image can be found.
     */
    public function createImage(\IImage $image, $target_width)
    {            
        if($target_width > 2560)
        {
            $target_width = 2560;
        }

        $ds = DIRECTORY_SEPARATOR;
        $original_path = $image->getOriginalPath();
        $target_path = $image->getImagePath($target_width);
        $target_directory = dirname($target_path);

        if (!$original_path || !file_exists($original_path))
        {
            throw new Exception("The original image: '$original_path'"
                    . " does not exist!");
        }

        if(!file_exists($target_directory) && !mkdir ($target_directory, 0755, TRUE))
        {
            throw new Exception("Could not make the directory: "
                    . "'$target_directory'!");
        }

        $original_image_space = $this->createImagicImageSpace(
                $original_path);
        $image_aspect = imagesx($original_image_space)/$target_width;
        $target_height = imagesy($original_image_space)/$image_aspect;

        if($target_height > 4000)
        {
            return $original_path;
        }
        
        return $this->resizeImage($original_path, $target_path, 
                $target_width, $target_height);
    }

    /**
     *  Generate a thumbnail out of the Image original with $with, $height
     * 
     * @param \IImage $image
     * @param integer $width
     * @param integer $height
     * @param integer[4] $coords    Pass FALSE to autogenerate
     * @param boolean $rescale
     * @return string
     * @throws Exception
     */
    public function createCrop(\IImage $image, $width,$height, $coords = NULL, 
            $rescale = NULL)
    {
        if($width > 1280)
        {
            throw new Exception("Thumbnails are not allowed to"
                    . " get wider than 1280 pixels.");
        }
        if($height > 800)
        {
            throw new Exception("Thumbnails are not allowed to"
                    . " get higher than 800 pixels.");
        }

        $targetSize = array(
            'h' => $height,
            'w' => $width,
        );

        $original_path = $image->getOriginalPath();
        $target_path = $image->getThumbnailPath($width, $height);
        $target_directory = dirname($target_path);
        
        if(!file_exists($original_path))
        {
            throw new Exception("The file $original_path does not exist!");
        }

        if(!file_exists($target_directory) && !mkdir ($target_directory, 0755, TRUE))
        {
            throw new Exception("Could not make the directory: "
                    . "'$target_directory'!");
        }
        $jcropper = $this->getCropper();
        $jcropper->thumbnailName = $target_path;
        $jcropper->setImage($original_path);

        $thumbnail = $jcropper->crop($coords,$targetSize, $rescale);

        return $thumbnail;
    }       
}