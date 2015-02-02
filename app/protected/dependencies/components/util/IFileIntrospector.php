<?php
/**
 *
 * @author kiriakos
 */
interface IFileIntrospector 
{
    public function isImg(IFileSystemAsset $node);
    public function isPdf(IFileSystemAsset $node);
    
    /**
     * This method evolves instances o IFileSystemAsset into IImage or Ipdf
     */
    public function assetize();
}
