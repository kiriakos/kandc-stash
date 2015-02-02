<?php

/**
 * Description of PathManagerTest
 *
 * @author kiriakos
 * 
 * @group PathManager
 * @group Component
 * @group files
 */
class PathManagerTest 
extends KncTestCase
{
    public function testGetPathOfAlias()
    {
        $component = new MockComponent('tests.mocks');
        $pm = new PathManager($component);
        
        $base_path = '/home/kiriakos/Devel/kindstudios/kandc-lib-web/app/protected';
        
        $config_path = $base_path. '/configs/tests/mocks.php';
        $interface_path = $base_path. '/dependencies/tests/mocks.php';
        $class_path = $base_path. '/classes/tests/mocks.php';

        // Test basic alias pathing
        $this->assertEquals($class_path, $pm->getPathOfAlias('tests.mocks'));
        $this->assertEquals($class_path, $pm->getPathOfAlias('tests.mocks', 
                PathTypes::CLASS_FILE));
        
        $this->assertEquals($config_path, $pm->getPathOfAlias('tests.mocks', 
                PathTypes::CONFIG_FILE));
        
        $this->assertEquals($interface_path, $pm->getPathOfAlias('tests.mocks', 
                PathTypes::INTERFACE_FILE));
        
        //Test self refferencing
        $this->assertEquals($config_path, $pm->getConfigFilePath());
    }

    public function getComponentAlias() {
        
    }

}

