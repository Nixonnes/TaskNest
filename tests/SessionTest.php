<?php

use Core\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    protected function setUp(): void
    {
        // Инициализация сессии
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
    }
    public function testSetAndGet()
    {
        Session::set('key', 'value');
        $this->assertEquals('value', Session::get('key'));
    }
    public function testRemove()
    {
        Session::set('key', 'value');
        Session::remove('key');
        $this->assertNull(Session::get('key'));
    }
    public function testHas()
    {
        Session::set('key', 'value');
        $this->assertTrue(Session::has('key'));
        $this->assertFalse(Session::has('non-existing'));
    }
    public function testClear()
    {
        Session::set('key1','value1');
        Session::set('key2','value2');
        Session::clear();
        $this->assertFalse(Session::has('key1'));
        $this->assertFalse(Session::has('key2'));
    }
    public function testFlash(): void
    {
        Session::flash('message', 'This is a flash message');
        $this->assertSame('This is a flash message', Session::getFlash('message'));
        $this->assertNull(Session::get('message'));
    }

    public function testGetFlashRemovesKey(): void
    {
        Session::set('message', 'Persisting message');
        Session::flash('temp', 'Temporary message');
        Session::getFlash('temp');
        $this->assertFalse(Session::has('temp'));
        $this->assertTrue(Session::has('message'));
    }
}