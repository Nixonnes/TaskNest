<?php

use Core\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testGetContent()
    {
        $response = new Response();
        $this->assertEquals('', $response->getContent());
    }
    public function testSetContent()
    {
        $response = new Response();
        $response->setContent('test');
        $this->assertEquals('test', $response->getContent());
    }
    public function testAddHeader()
    {
        $response = new Response();
        $response->addHeader('Content-Type', 'text/html');
        $this->assertEquals(['Content-Type' => 'text/html'], $response->getHeaders());
    }
}