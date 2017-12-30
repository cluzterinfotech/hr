<?php

namespace ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ApplicationControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $this->setApplicationConfig(
            include '/var/www/zf2-tutorial/config/application.config.php'
        );
        parent::setUp();
    }
    
    public function testIndexActionCanBeAccessed()
    {
    	$this->dispatch('/album');
    	$this->assertResponseStatusCode(200);
    
    	$this->assertModuleName('Album');
    	$this->assertControllerName('Album\Controller\Album');
    	$this->assertControllerClass('AlbumController');
    	$this->assertMatchedRouteName('album');
    }
}