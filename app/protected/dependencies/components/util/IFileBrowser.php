<?php
/**
 *
 * @author kiriakos
 */
interface IFileBrowser 
{
    /**
     * Go to the directory path
     * 
     * This is also the only way to connect to a relative directory.
     * 
     * @param type $relative_directory_path
     */
    public function openDirectory($relative_directory_path);
    
    /**
     * Set the base path for resolving relative paths
     * 
     * This is also the only way to connect to an absolute path.
     * 
     * @param type $absolute_path
     */
    public function setBasePath($absolute_path);
    
    /**
     * Get the path from which acts as the FS root for this usage.
     */
    public function getBasePath();
    
    /**
     * Get the currently opened path
     */
    public function getCurrentPath();
    
    /**
     * Get the currently opened path relative to the asset root
     */
    public function getRelativeCurrentPath();
    
    
    /**
     * Get a list of file names in the current directory
     * 
     * @return array
     */
    public function getFiles(callable $filter_callback = NULL);
            
    /**
     * Get directories in the current directory
     * 
     * by default only returns the first level. Set depth to more to add 
     * recursion.
     * 
     * @return array
     */
    public function getSubs(callable $filter_callback = NULL, $depth = 1);
    
    
    /**
     *
     * @param n     the nth object to return 
     * @param return IFileSystemAsset
     */
    public function getNthFile($n);
    
    /**
     * 
     * @param n     the nth object to return 
     * @param return IFileSystemAsset
     */
    public function getNthSubdirectory($n);
    
    
    /**
     * Whether the Browser is connected to an FS node.
     * 
     * When using IFileBrowser you typically will have to explicitly connect to
     * a file system node. The functions for this are:
     *  - setBasePath($absolute_path) to open an absolute path
     *  - openDirectory($relativa_path) to open a relative directory
     */
    public function isConnected();
    
    /**
     * Publish a file to a web accessible path
     * 
     * The file system asset is put into the given path. The returned Uri 
     * contains web access information.
     * 
     * @param string $current_path      The absolute path to a file.
     * @param string $target_path       The realtive target path. (relative to
     *                                  assets directory)
     * @return \IFileSystemAsset        The asset created.
     */
    public function publishForeignFile($current_path, $target_path);
    
    /**
     * Whether the file $target_path exists
     * 
     * @param string $target_path
     * @return boolean
     */
    public function fileInPathExists($target_path);
}
