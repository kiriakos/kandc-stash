<?php
/**
 *
 * @author kiriakos
 */
interface IFileSystemAsset 
{
    const NODE_TYPE_BYTESTREAM = 1;
    const NODE_TYPE_STRUCTURE = 0;

    public function setName($name);
    public function setPath($path);
    public function setIndexInListing($integer);
    public function setNodeType($type);
    
    public function getName();
    public function getPath();
    public function getIndexInListing();
    public function getNodeType();
    
    public function isDocument();
    public function isStructureNode();
}
