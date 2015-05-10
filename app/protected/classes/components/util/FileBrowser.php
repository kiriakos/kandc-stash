<?php
/**
 * Naive Implementation of IFileBrowser
 *
 * @method IFileSystemAsset getFileSystemAsset() Generates a file system asset instance
 * @method ISanitizer getSanitizer()    A file path sanitizer
 * @author kiriakos
 */
class FileBrowser 
extends Component
implements IFileBrowser
{
    /**
     * Directory pointer
     *
     * @var pointer 
     */
    private $_directory_pointer;
    
    /**
     * Absolute path
     *
     * @var string
     */
    private $_base_path;
    
    /**
     * The relative path that is currently being used
     *
     * @var string 
     */
    private $_current_path;
    
    
    
    /**
     * Gets the files in the opened Directory
     * 
     * implicitly calls connect() to reset the file pointer. This is needed in 
     * order to call getFiles() and getSubs() without changing base or
     * directory.
     * 
     * @param callable $filter_callback
     * @return IFileSystemAsset[]
     */
    public function getFiles(callable $filter_callback = NULL) 
    {         
        $this->connect(); // Force resetting of the file pointer
        if(!$this->isConnected())
        {
            $this->throwConnectionException();
        }
        
        $files = array();
        $assets = array();
        $type = IFileSystemAsset::NODE_TYPE_BYTESTREAM;
        
        while( ($file = readdir($this->_directory_pointer)) !== FALSE )
        {
            $files[] = $file;
        }
        
        sort($files);
        
        foreach($files as $file)
        {
            $asset_path = $this->getCurrentPath(). DIRECTORY_SEPARATOR. $file;
            
            if($filter_callback !== NULL
                    && !call_user_func($filter_callback, $file))
            {
                continue;
            }
            elseif(!is_dir($asset_path))
            {
                $assets[] = $this->createAsset($file, $asset_path, $type, 
                        count($assets));
            }
        }
        
        return $assets;
    }
    
    /**
     * Get the Subdirectories in teh opened directory
     * 
     * Implicitly calls connect() to reset the file pointer. This is needed in 
     * order to call getFiles() and getSubs() without changing base or 
     * directory.
     * 
     * @param callable $filter_callback
     * @param integer $depth    Currently ignored!
     * @return IFileSystemAsset[]
     */
    public function getSubs(callable $filter_callback = NULL, $depth = 1) 
    {
        $this->connect(); // Force resetting of the file pointer
        if(!$this->isConnected())
        {
            $this->throwConnectionException();
        }
        
        $nodes = array();
        $assets = array();
        $type = IFileSystemAsset::NODE_TYPE_STRUCTURE;
        
        while( ($node = readdir($this->_directory_pointer)) !== FALSE )
        {
            $nodes[] = $node;
        }
        
        sort($nodes);
        
        foreach($nodes as $node)
        {
            $path = $this->getCurrentPath(). DIRECTORY_SEPARATOR. $node;
            
            if($filter_callback !== NULL
                    && !call_user_func($filter_callback, $node))
            {
                continue;
            }
            elseif ($node == '.' || $node == '..')
            {
                continue;
            }
            elseif(is_dir($path))
            {
                $assets[] = $this->createAsset($node, $path, $type, 
                        count($assets));
            }
        }
        
        return $assets;
    }
    
    /**
     * 
     * @param string $name
     * @param string $path
     * @param integer $type
     * @param integer $index
     * @return IFileSystemAsset
     */
    private function createAsset($name, $path, $type, $index)
    {
        $asset = $this->getFileSystemAsset();
        $asset->setName($name);
        $asset->setPath($path);
        $asset->setNodeType($type);
        $asset->setIndexInListing($index);

        return $asset;
    }

    private function throwConnectionException()
    {
        throw new Exception("FileBrowser has to connect to a file system"
            . " node in order to provide File and Subdirectory"
            . " listings!");
    }

    /**
     * Uses a relative path and the set BasePath to set a fopen pointer on FS.
     * 
     * This method sanitizes it's input.
     * 
     * @see FileBrowser::setBasePath()
     * @param type $relative_directory_path
     * @return boolean
     */
    public function openDirectory($relative_directory_path)
    {
        $this->setCurrentPath($relative_directory_path);
        $this->connect();
    }
    
    
    private function setCurrentPath($relative_directory_path)
    {
        $this->_current_path = $this->getSanitizer()
                ->sanitize($relative_directory_path);
    }
    
    /**
     * Required for configuration purposes!
     * 
     * WARNING: this method is required for component configuration via the
     *          attributes array in dependency declarations!
     * 
     * @param type $path
     * @throws Exception
     */
    protected function setInitPath($path)
    {
        $abs_path = realpath($path);
        if(!file_exists($abs_path))
        {
            throw new Exception("Path: $abs_path is non existent!");
        }
        
        $this->setBasePath($abs_path);
    }
    
    
    /**
     * FileBrowser methods will not cross this thresshold
     * 
     * @see FileBrowser::openDirectory()
     * @param string $absolute_path
     */
    public function setBasePath($absolute_path) 
    {
        $this->_base_path = $absolute_path;
        $this->connect();
    }

    private function connect()
    {
        $this->_directory_pointer = opendir($this->getCurrentPath());
        if($this->_directory_pointer === FALSE)
        {
            throw new Exception("Could not open the path: ". $this->getCurrentPath());
        }
        
        return $this->isConnected();
    }
    
    public function getCurrentPath()
    {
        if($this->_current_path)
        {
            return realpath($this->_base_path. DIRECTORY_SEPARATOR. $this->_current_path);
        }
        else 
        {
            return $this->_base_path;
        }
    }

    /**
     * 
     * @return string
     */
    public function getRelativeCurrentPath() {
        return str_replace($this->getBasePath(), "",$this->getCurrentPath());
    }
    
    /**
     * Shorthand to get the Nth item of the documents/bytestreams list
     * 
     * @param integer $n
     * @return IFileSystemAsset
     */
    public function getNthFile($n) 
    {
        return $this->getNthOfList($this->getFiles(), $n);
    }

    /**
     * Shorthand to get the Nth item of the subdirectories list
     * 
     * @param integer $n
     * @return IFileSystemAsset
     */
    public function getNthSubdirectory($n) 
    {
        return $this->getNthOfList($this->getSubs(), $n);
    }
    
    /**
     * 
     * @param type $list
     * @param type $n
     * @return type
     */
    public function getNthOfList($list, $n)
    {
        if(count($list) >= $n)
        {
            return $list[$n + 1];
        }
        else
        {
            return NULL;
        }
    }

    public function getBasePath()
    {
        return $this->_base_path;
    }

    public function isConnected() 
    {
        return is_resource($this->_directory_pointer);
    }
    
    public function getBackNode()
    {
        return $this->createAsset('Back', 
                $this->getCurrentPath(). DIRECTORY_SEPARATOR. '..', 
                IFileSystemAsset::NODE_TYPE_STRUCTURE, '0');
    }
    
    /**
     * Adds a foreign file under the basepath.
     * 
     * @param string $current_path      The absolute path to a file.
     * @param string $target_path       The realtive target path. (relative to
     *                                  assets directory)
     * @return \IFileSystemAsset        The asset created.
     */
    public function publishForeignFile($current_path, $target_path) 
    {
        $dest_path = $this->getBasePath() . DIRECTORY_SEPARATOR . $target_path;
        $dest_dir = dirname($dest_path);
        
        if(!is_dir($dest_dir))
        {
            mkdir($dest_dir, 0775, TRUE);
        }
        
        if(rename($current_path, $dest_path))
        {
            $this->setCurrentPath(dirname($target_path));
            $files = $this->getFiles();
        }
        else
        {
            $this->throwFileCopyException($current_path, $dest_path);
        }
        
        foreach($files as $file)
        {
            if($file->getPath() == $dest_path)
            {
                return $file;
            }
        }
        
        return NULL;
    }
    
    private function throwFileCopyException($path, $dest)
    {
        $msg ="Could not rename $current_path to $dest_path!";
        
        if(!is_readable($path))
        {
            $msg .= "\nCurrent path: '$path' is not readable!";
        }
        
        if(!is_writable($dest))
        {
            $msg .= "\nDestination path: '$dest' is not writable!";
        }
        
        throw new BadMethodCallException($msg);
    }

}
