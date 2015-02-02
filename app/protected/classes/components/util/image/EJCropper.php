<?php

/**
 * Base class.
 */
class EJCropper
extends Component
implements ICropper
{
    /**
     * @var integer JPEG image quality
     */
    public $jpeg_quality = 100;

    /**
     * @var integer PNG image quality 0 = no compression
     */
    public $png_quality = 0;

    /**
     * @var integer the default thumbnail width
     */
    public $thumbnailWidth = 100;
    /**
     * @var integer the default thumbnail height
     */
    public $thumbnailHeight = 100;

    public $thumbnailAspect = 1;
    /**
     * DEPRECATED: use $thumbnailName
     * @var string The path for saving thumbnails
     */
    public $thumbnailPath = null;

    public $thumbnailName = null;


    private $imageInstance = null;
    private $imageFileType = null;
    public function setImage($imageSource)
    {
            //load image inte $this->imageInstance
            $this->imageFileType = pathinfo($imageSource, PATHINFO_EXTENSION);
            if ($this->imageFileType == 'jpg' || $this->imageFileType == 'jpeg')
                    $this->imageInstance = imagecreatefromjpeg($imageSource);
            elseif ($this->imageFileType == 'png')
                    $this->imageInstance = imagecreatefrompng($imageSource);
            elseif ($this->imageFileType == 'gif')
                    $this->imageInstance = imagecreatefromgif($imageSource);
            else
                    return false;
    }

    /**
     * Crop an image and save the result.
     * 
     * @param string $imageSource Source (original) image path.
     * @param array $coords Cropping coordinates.
     * @param array $targetSize Cropping coordinates.
     * @return string $thumbName Path to thumbnail.
     */
    public function crop($coords, $targetSize = null, $rescale = TRUE)
    {
        //set the resulting image's dims if passed
        if ($targetSize){
            $this->thumbnailHeight = $targetSize['h'];
            $this->thumbnailWidth = $targetSize['w'];
            $this->thumbnailAspect = $this->thumbnailWidth/$this->thumbnailHeight;
        }

        //generate the resulting images path + filename
        if (!$this->thumbnailName)
        {
                throw new Exception(__CLASS__ . ' : at least'
                        . ' `thumbnailName` is' . ' required.');
        }
        
        $thumbName = $this->thumbnailName;
        
        if (!$coords) //no coords passed, generate x0,y0,w,h
        {
            $coords = $this->generateCropCoords($this->thumbnailWidth, 
                    $this->thumbnailHeight);
        }

        if ( round( $coords['w']/$coords['h'], 1) !=
                round($this->thumbnailAspect, 1))
        {
                $coords = $this->refitCropCoords ($coords, 
                        $this->thumbnailAspect);
        }

        //scale the coord props to the real images props
        if ($rescale)
        {
            $coords = $this->rescaleCoordsToImage( $coords, 
                    Image::UPDATE_WIDTH);
        }

        if (!$this->coordsValid($coords))
        {
            $coords = $this->generateCropCoords($this->thumbnailWidth,
                    $this->thumbnailHeight);
        }

        //create the result image's context
        $thumbnailInstance = imagecreatetruecolor(
                $this->thumbnailWidth, $this->thumbnailHeight);


        //Transparency
        if ($this->imageFileType == 'png' 
                || $this->imageFileType == 'gif')
        {
                imagealphablending($thumbnailInstance, false);
                imagesavealpha($thumbnailInstance,true);
                $transparent = imagecolorallocatealpha($thumbnailInstance,
                        255, 255, 255, 127);
                imagefilledrectangle($thumbnailInstance, 0, 0,
                        $this->thumbnailWidth, $this->thumbnailHeight,
                        $transparent);
        }

        if (!imagecopyresampled(
                $thumbnailInstance, $this->imageInstance, //dst, src
                0, 0, //dst,
                $coords['x'], $coords['y'],//src,
                $this->thumbnailWidth, $this->thumbnailHeight, //dst,
                $coords['w'], $coords['h']//src,
                ))
        {
                return false;
        }

        // save png or jpeg pictures only
        if ($this->imageFileType == 'jpg' || $this->imageFileType == 'jpeg') 
        {
                imagejpeg($thumbnailInstance, $thumbName, $this->jpeg_quality);
        }
        elseif ($this->imageFileType == 'png') 
        {
                imagepng($thumbnailInstance, $thumbName, $this->png_quality);
        }
        elseif ($this->imageFileType == 'gif') 
        {
                imagegif($thumbnailInstance, $thumbName);
        }

        return $thumbName;
    }

    /**
     *  Scales coords of an image displayed with width=$width to real dims
     *
     * in the crop application (image/update action) the images are
     * displayed scaled to a maximum width. the same will be true for the
     * front end applcation so you need to be able to map the  relative
     * coordinates fed to you by the plugin onto the original image.
     *
     * @param array $coords
     * @param integer $width
     * @return array
     */
    public function rescaleCoordsToImage( $coords, $width = Image::UPDATE_WIDTH )
    {
        $image = $this->imageInstance;
        $imageX = imagesx($image); //width
        $newCoords = array();
        $ratio = $imageX/$width; // eg 2.109

        foreach ($coords as $key=>$value)
        {
            $newCoords[$key] = intval($ratio*$value); //eg 1209 not 1208.76   
        }

        return $newCoords;
    }


    /**
     *  Generates crop coords for a centered crop on $originalInstance
     *
     * should always generate valid coords
     * 
     * @param integer $endW
     * @param integer $endH
     * @return array
     */
    public function generateCropCoords($endW,$endH)
    {
            $originalInstance = $this->imageInstance;

            $origW = imagesx($originalInstance);
            $origH = imagesy($originalInstance);
            $origRatio= $origW/$origH;

            $endRatio = $endW/$endH;

            if($endRatio>$origRatio) //end will go from origTop to origBottom
            {
                $cropW=$origW;
                $cropH=$cropW/$endRatio;
                $cropX=0;
                $cropY=($origH-$cropH)/2;
            }
            else //end
            {
                $cropH=$origH;
                $cropW=$cropH*$endRatio;
                $cropY=0;
                $cropX=($origW-$cropW)/2;
            }

            $coords = array(
                'x'=>$cropX,
                'y'=>$cropY,
                'x2'=>$cropX+$cropW,
                'y2'=>$cropY+$cropH,
                'w'=>$cropW,
                'h'=>$cropH,
            );

            return $coords;
    }

    /**
     *  Takes a $coords array and scales it to $aspect
     * @param array $coords
     * @param float $targetAspect
     * @return array | false
     */
    public function refitCropCoords($coords,$targetAspect)
    {
            $ocoords = $coords;

            if(!isset($coords['w']) || !$coords['w'])
            {
                $coords['w'] = $coords['x2']-$coords['x'];
            }
            if(!isset($coords['h']) || !$coords['h'])
            {
                $coords['h'] = $coords['y2']-$coords['y'];   
            }

            $originalAspect = $oA = $coords['w']/$coords['h'];
            $tA = $targetAspect;

            if($tA< $coords['w']/$coords['h'])
            {
                //widen
                $origW = $coords['w'];
                $coords['w'] = $coords['w']*($tA/$oA);//anaW
                $coords['x'] = $coords['x']-($coords['w'] - $origW)/2;
                $coords['x2']= $coords['x']+$coords['w'];
            }
            else
            {
                //heighten
                $origH = $coords['h'];
                $coords['h'] = $coords['h']/($tA/$oA);//anaH
                $coords['y'] = $coords['y']-($coords['h'] - $origH)/2;
                $coords['y2'] = $coords['y']+$coords['h'];
            }

            return $coords;
    }

    /**
     *  Checks to see if the coords are legal
     *
     * @param array $coords
     * @param resource $image
     * @return boolean
     */
    protected function coordsValid($coords)
    {
        $image = $this->imageInstance;

        $coos = array('x','x2','y','y2','w','h');
        foreach ($coos as $coo)
        {
            if (!isset($coords[$coo]) || $coords[$coo] < 0)
            {
                return false;
            }
        }

        $instW = imagesx($image);
        $instH = imagesy($image);

        if ($coords['x']+$coords['w'] > $instW)
        {
            throw new Exception($this->thumbnailName. $coords['x']
                    . "+". $coords['w']. " > ". $instW , 000);
            return false;
        }
        if ($coords['y']+$coords['h'] > $instH)
        {
            throw new Exception($this->thumbnailName. $coords['y']
                    . "+". $coords['h']. " > ". $instH , 000);
            return false;
        }

        return true;
    }
}