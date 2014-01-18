<?php

namespace CkanConsumerTest\Unit\Http\Client;

use CkanConsumer\Http\Client\Stream;

class StreamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CkanConsumer\Http\Client\Stream::__construct
     */
    public function testConstructCorrectInterface()
    {
        $stream = new Stream();

        $this->assertInstanceOf('\\CkanConsumer\\Http\\Client', $stream);
    }

    /**
     * @covers CkanConsumer\Http\Client\Stream::__construct
     */
    public function testConstructCorrectInstance()
    {
        $stream = new Stream();

        $this->assertInstanceOf('\\CkanConsumer\\Http\\Client\\Stream', $stream);
    }

    /**
     * @covers CkanConsumer\Http\Client\Stream::__construct
     */
    public function testConstructCustomUserAgent()
    {
        $stream = new Stream('CustomUserAgent');

        $this->assertInstanceOf('\\CkanConsumer\\Http\\Client\\Stream', $stream);
    }

    /**
     * @covers CkanConsumer\Http\Client\Stream::__construct
     * @covers CkanConsumer\Http\Client\Stream::setMaxRedirects
     */
    public function testSetMaxRedirects()
    {
        $stream = new Stream();

        $this->assertInstanceOf('\\CkanConsumer\\Http\\Client\\Stream', $stream->setMaxRedirects(10));
    }

    /**
     * @covers CkanConsumer\Http\Client\Stream::__construct
     * @covers CkanConsumer\Http\Client\Stream::setTimeout
     */
    public function testSetTimeout()
    {
        $stream = new Stream();

        $this->assertInstanceOf('\\CkanConsumer\\Http\\Client\\Stream', $stream->setTimeout(10));
    }

    /**
     * @covers CkanConsumer\Http\Client\Stream::__construct
     * @covers CkanConsumer\Http\Client\Stream::post
     * @covers CkanConsumer\Http\Client\Stream::request
     * @covers CkanConsumer\Http\Client\Stream::generateStreamContext
     */
    public function testPostWithoutBodyAndHeaders()
    {
        $stream = new Stream();

        $result = json_decode($stream->post('https://httpbin.org/post'), true);

        $this->assertSame('http://httpbin.org/post', $result['url']);
        $this->assertSame('CkanConsumerLib', $result['headers']['User-Agent']);
    }

    /**
     * @covers CkanConsumer\Http\Client\Stream::__construct
     * @covers CkanConsumer\Http\Client\Stream::post
     * @covers CkanConsumer\Http\Client\Stream::request
     * @covers CkanConsumer\Http\Client\Stream::generateStreamContext
     */
    public function testPostWithoutBodyAndHeadersAndCustomUserAgent()
    {
        $stream = new Stream('FooClient');

        $result = json_decode($stream->post('https://httpbin.org/post'), true);

        $this->assertSame('FooClient', $result['headers']['User-Agent']);
    }

    /**
     * @covers CkanConsumer\Http\Client\Stream::__construct
     * @covers CkanConsumer\Http\Client\Stream::post
     * @covers CkanConsumer\Http\Client\Stream::request
     * @covers CkanConsumer\Http\Client\Stream::generateStreamContext
     */
    public function testPostWithBodyWithoutHeaders()
    {
        $stream = new Stream();

        $result = json_decode($stream->post('https://httpbin.org/post', ['foo' => 'bar']), true);

        $this->assertTrue(array_key_exists('foo', $result['form']));
        $this->assertSame('bar', $result['form']['foo']);
    }

    /**
     * @covers CkanConsumer\Http\Client\Stream::__construct
     * @covers CkanConsumer\Http\Client\Stream::post
     * @covers CkanConsumer\Http\Client\Stream::request
     * @covers CkanConsumer\Http\Client\Stream::generateStreamContext
     */
    public function testPostWithoutBodyWithHeaders()
    {
        $stream = new Stream();

        $result = json_decode($stream->post('https://httpbin.org/post', [], ['Foo: bar']), true);

        $this->assertTrue(array_key_exists('Foo', $result['headers']));
        $this->assertSame('bar', $result['headers']['Foo']);
    }

    /**
     * @covers CkanConsumer\Http\Client\Stream::__construct
     * @covers CkanConsumer\Http\Client\Stream::post
     * @covers CkanConsumer\Http\Client\Stream::request
     * @covers CkanConsumer\Http\Client\Stream::generateStreamContext
     */
    public function testRequestClosesConnection()
    {
        $stream = new Stream();

        $result = json_decode($stream->post('https://httpbin.org/post'), true);

        $this->assertTrue(array_key_exists('Connection', $result['headers']));
        $this->assertSame('close', $result['headers']['Connection']);
    }

    /**
     * @covers CkanConsumer\Http\Client\Stream::__construct
     * @covers CkanConsumer\Http\Client\Stream::post
     * @covers CkanConsumer\Http\Client\Stream::request
     * @covers CkanConsumer\Http\Client\Stream::generateStreamContext
     */
    public function testRequestCorrectContentLength()
    {
        $stream = new Stream();

        $result = json_decode($stream->post('https://httpbin.org/post', ['foo' => 'bar']), true);

        $this->assertTrue(array_key_exists('Content-Length', $result['headers']));
        $this->assertSame('7', $result['headers']['Content-Length']);
    }

    /**
     * @covers CkanConsumer\Http\Client\Stream::__construct
     * @covers CkanConsumer\Http\Client\Stream::get
     * @covers CkanConsumer\Http\Client\Stream::request
     * @covers CkanConsumer\Http\Client\Stream::generateStreamContext
     */
    public function testGetWithoutHeaders()
    {
        $stream = new Stream();

        $result = json_decode($stream->get('https://httpbin.org/get'), true);

        $this->assertSame('http://httpbin.org/get', $result['url']);
        $this->assertSame('CkanConsumerLib', $result['headers']['User-Agent']);
    }
}
