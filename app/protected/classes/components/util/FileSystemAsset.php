<?php
/**
 * A node on a file systen.
 * 
 * The set methods only work once! They will throw exceptions afterwards.
 * This is designed to be used as a read only object (or Value Object)
 *
 * @method IFileIntrospector getFileIntrospector() Dependency
 * @method IFilePublisher    getFilePublisher() Dependency
 * 
 * @author kiriakos
 */
class FileSystemAsset 
extends Component
implements IFileSystemAsset
{    
    private $name;
    private $path;
    private $node_type;
    private $index_in_listing;
    
    public function getNodeType() 
    {
        return $this->node_type;
    }
    
    /**
     * Zero initialized index
     * 
     * @return integer
     */
    public function getIndexInListing() 
    {
        return $this->index_in_listing;
    }

    public function getName() 
    {
        return $this->name;
    }

    public function getPath() 
    {
        return $this->path;
    }

    /**
     * Whether the Asset is a bytestream (document)
     * 
     * NOTE: Do not confuse this with the UNIX "everythnig is a file" moniker.
     *       This will return false on *NIXes when the asset is a directory
     *       node.
     * 
     * @return boolean
     */
    public function isDocument() 
    {
        return $this->node_type === self::NODE_TYPE_BYTESTREAM;
    }

    /**
     * Whether the asset is a directory node
     * 
     * @return boolean
     */
    public function isStructureNode() 
    {
        return $this->node_type === self::NODE_TYPE_STRUCTURE;
    }

    /**
     * Used to throw an exception for multi setter invocation.
     * 
     * @param string $property_name
     * @throws Exception
     */
    private function throwDoubleSetterInvocationException($property_name)
    {
        throw new Exception("The properties of FileSystemAsset instances"
                . " are designed to be set once get many! Tried to set "
                . " property '$property_name' twice.");
    }
    
    /**
     * Zero initialized index
     * 
     * @param integer $integer
     */
    public function setIndexInListing($integer) 
    {
        if($this->index_in_listing !== NULL)
        {
            $this->throwDoubleSetterInvocationException('index_in_listing');
        }
        
        $this->index_in_listing = $integer;
    }
    
    public function setName($name) 
    {
        if($this->name !== NULL)
        {
            $this->throwDoubleSetterInvocationException('name');
        }
        
        $this->name = $name;
    }

    public function setPath($path) 
    {
        if($this->path !== NULL)
        {
            $this->throwDoubleSetterInvocationException('path');
        }
        
        $this->path = $path;
    }

    public function setNodeType($type) 
    {
        if($this->node_type !== NULL)
        {
            $this->throwDoubleSetterInvocationException('node_type');
        }
        
        $valid_types = array(
            self::NODE_TYPE_BYTESTREAM,
            self::NODE_TYPE_STRUCTURE
        );
        
        if(!in_array($type, $valid_types))
        {
            throw new Exception('The type attribute has to equal one of the'
                    . ' FileSystemAsset::NODE_TYPE_XX constants.');
        }
        $this->node_type = $type;
    }
}