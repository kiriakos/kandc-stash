<?php
/**
 *
 * @author kiriakos
 */
interface IFilePublisher 
{
    /**
     * Publish an asset
     * 
     * @param IFileSystemAsset $asset
     * @return IUri     The URI where the published file can be retrieved. 
     *                  Authentication may apply
     */
    public function publishAsset(IFileSystemAsset $asset);
    
    /**
     * Publish the calling component. 
     * 
     * NOTE:    only works if the component calling the dependency implements
     *          IFileSystemAsset.
     * 
     * @return IUri  The URI where the published file can be retrieved. 
     *               Authentication may apply
     */
    public function publishCaller();    
    
    /**
     * Create a web accessible path from a filesystem path
     * 
     * @return IUri  The URI where the published file can be retrieved. 
     *               Authentication may apply
     */
    public function publishPathString($string);
    
    /**
     * Publish a file to a web accessible path
     * 
     * The file system asset is put into the given path. The returned Uri 
     * contains web access information.
     * 
     * @param IFileSystemAsset $file    The file to publish.
     * @param strign $path              The web accessible path.
     * @return IUri  The URI where the published file can be retrieved. 
     *               Authentication may apply
     */
    public function publishForeignFile(IFileSystemAsset $file, $path);
    
    
}
