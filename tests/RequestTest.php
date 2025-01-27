<?php

class RequestTest extends \PHPUnit\Framework\TestCase
{

    public function testUri()
    {
        $_SERVER['REQUEST_URI'] = '/test';
        $this->assertEquals('/test', \Core\Request::uri());
    }
    public function testMethod()
    {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $this->assertEquals('GET', \Core\Request::method());
    }
    public function testGetParam()
    {
        $_GET['test'] = 'value';
        $this->assertEquals('value', (new \Core\Request())->getParam('test'));
    }
    public function testIsPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertEquals('POST', \Core\Request::method());
    }
    public function testIsGet()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertEquals('GET', \Core\Request::method());
    }
}