<?php
/**
 * Description of SimpleRouterTest
 *
 * @author kiriakos
 */
class SimpleRouterTest
extends KncTestCase

{
    // uri => expected route
    private $route_validate_auto_uri = array(
        "/uploads/file"=>"uploads/file",
        "/thumbnails/1400_20/some/dir.name" => FALSE,
        "/images/1400/some/file.name" => FALSE,
    );
    
    // uri => expected route
    private $route_validate_custom_uri = array(
        "/images/100/test/file.path"=>"images/images",
        "/thumbnails/100_100/test/file.path"=>"images/thumbnails",
    );
    
    private $findController = [
        "Uploads" => "UploadsController",
    ];
    
    public function testUriAutoRouting()
    {
        foreach($this->route_validate_auto_uri as $uri=>$expected)
        {
            $this->assertEquals($expected, $this->getComponent()
                    ->parseAutoRoutable(new RequestMock($uri)));
        }
    }
    
    public function testUriCustomRouting()
    {
        foreach($this->route_validate_custom_uri as $uri=>$expected)
        {
            $this->assertEquals($expected, $this->getComponent()
                    ->parseCustomRoutable(new RequestMock($uri)));
        }
    }
    
    public function testFindControlerByName()
    {
        $router = $this->getComponent();
        
        foreach($this->findController as $name => $class)
        {
            $ctrlr = $router->findControllerByName($name);
            $this->assertEquals($class, get_class($ctrlr));
        }
        
    }
    
    public function getComponentAlias() {
        return 'components.simple.SimpleRouter';
    }
}

require_once APP_ROOT ."/protected/dependencies/components/IRequest.php";

class RequestMock
implements IRequest
{
    private $uri;
    public function __construct($uri) {
        $this->uri = $uri;
    }
    
    public function getCookie() {
        return NULL;
    }

    public function getParameter($name, $filter = FILTER_UNSAFE_RAW) {
        return NULL;
    }

    public function getParameterOr($name, $or_value, $filter) {
        return NULL;
    }

    public function getRequestPath() {
        return WEB_ROOT. $this->uri;
    }

    public function getRequestUri() {
        return $this->uri;
    }

    public function getSchema() {
        return 'http';
    }

    public function getScriptName() {
        return WEB_ROOT . '/index.php';
    }

    public function getServer($property) {
        return NULL;
    }

    public function getVerb() {
        return NULL;
    }

    public function hasParameter($name) {
        return NULL;
    }

    public function getFile($name) {
        return NULL;
    }

}
