<?php
/**
 * Provides introspection on file system nodes
 * 
 * bases findings on file names, fs metadata and mime types
 *
 * @method IImage getImage() Description
 * @author kiriakos
 */
class FileIntrospector 
extends Component
implements IFileIntrospector
{
    private function resolveNode($node)
    {
        if($node === NULL )
        {
            if($this->getCaller() instanceof IFileSystemAsset)
            {
                $node = $this->getCaller();
            }
            else
            {
                throw new Exception("You either have to call this from a"
                        . " IFileSystemAsset implementation or provide a"
                        . " node!");
            }
        }
        
        return $node;
    }
    
    public function isImg(IFileSystemAsset $node = NULL)
    {
        $resolved_node = $this->resolveNode($node);
        
        return (bool) preg_match('@\.(jpg|jpeg|png|gif)$@', strtolower(
                $resolved_node->getPath()));
    }

    public function isPdf(IFileSystemAsset $node = NULL) 
    {
        $resolved_node = $this->resolveNode($node);
        
        return (bool) preg_match('@\.(pdf)$@', strtolower(
                $resolved_node->getPath()));
    }
    
    public function assetize()
    {
        $caller = $this->getCaller();
        
        if($this->isImg())
        {
            $asset = $this->getImage();
            $asset->setPath($caller->getPath());
            $asset->setNodeType($caller::NODE_TYPE_BYTESTREAM);
            $asset->setName($caller->getName());
            $asset->setIndexInListing($caller->getIndexInListing());
        
            return $asset;
        }
    }
}
