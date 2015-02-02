<?php
/**
 * Description of FileSystemPathSanitizerTest
 *
 * @author kiriakos
 */
class FileSystemPathSanitizerTest 
extends KncTestCase
{
    
    private $sanitize = array(
        '/one/two' => "/del/../one/two",
        "/" => "/del/../../../unit",
        "/one/three" => "/del/../one/two/../three",
        "/end" => "/end/del/..",
        "/" => "//",
        "/" => "///",
        "/one/two" => "/one//two"
    );
    
    public function testSanitize()
    {
        $fs = $this->getComponent();
        
        $this->assertInstanceOf('FileSystemPathSanitizer', $fs);
        
        foreach($this->sanitize as $expected => $seed)
        {
            $this->assertEquals($expected, $fs->sanitize($seed));
        }
    }

    public function getComponentAlias() {
        return "components.util.FileSystemPathSanitizer";
    }
    
    public function getInterface() {
        return "components.util.ISanitizer";
    }
}
