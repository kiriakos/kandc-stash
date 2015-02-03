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
    
}
