<?php

namespace CkanConsumerTest\Unit\Common;

use CkanConsumer\Common\Autoloader;
use FakeProject\NS\SomeClass;

class AutoloaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CkanConsumer\Common\Autoloader::__construct
     */
    public function testConstructCorrectInstance()
    {
        $autoloader = new Autoloader('Test', '/');

        $this->assertInstanceOf('\\CkanConsumer\\Common\\Autoloader', $autoloader);
    }

    /**
     * @covers CkanConsumer\Common\Autoloader::__construct
     * @covers CkanConsumer\Common\Autoloader::register
     */
    public function testRegister()
    {
        $autoloader = new Autoloader('Test', '/');

        $this->assertTrue($autoloader->register());
    }

    /**
     * @covers CkanConsumer\Common\Autoloader::__construct
     * @covers CkanConsumer\Common\Autoloader::register
     * @covers CkanConsumer\Common\Autoloader::unregister
     */
    public function testUnregister()
    {
        $autoloader = new Autoloader('Test', '/');

        $this->assertTrue($autoloader->register());
        $this->assertTrue($autoloader->unregister());
    }

    /**
     * @covers CkanConsumer\Common\Autoloader::__construct
     * @covers CkanConsumer\Common\Autoloader::register
     * @covers CkanConsumer\Common\Autoloader::load
     * @covers CkanConsumer\Common\Autoloader::getPath
     */
    public function testLoadSuccess()
    {
        $autoloader = new Autoloader(
            'FakeProject',
            dirname(__DIR__) . '/../Mocks/Common'
        );

        $this->assertTrue($autoloader->register());

        $someClass = new SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers CkanConsumer\Common\Autoloader::__construct
     * @covers CkanConsumer\Common\Autoloader::register
     * @covers CkanConsumer\Common\Autoloader::load
     * @covers CkanConsumer\Common\Autoloader::getPath
     */
    public function testLoadSuccessExtraSlashedNamespace()
    {
        $autoloader = new Autoloader(
            '\\\\FakeProject',
            dirname(__DIR__) . '/../Mocks/Common'
        );

        $this->assertTrue($autoloader->register());

        $someClass = new SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers CkanConsumer\Common\Autoloader::__construct
     * @covers CkanConsumer\Common\Autoloader::register
     * @covers CkanConsumer\Common\Autoloader::load
     * @covers CkanConsumer\Common\Autoloader::getPath
     */
    public function testLoadSuccessExtraForwardSlashedPath()
    {
        $autoloader = new Autoloader(
            'FakeProject',
            dirname(__DIR__) . '/../Mocks/Common//'
        );

        $this->assertTrue($autoloader->register());

        $someClass = new SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers CkanConsumer\Common\Autoloader::__construct
     * @covers CkanConsumer\Common\Autoloader::register
     * @covers CkanConsumer\Common\Autoloader::load
     * @covers CkanConsumer\Common\Autoloader::getPath
     */
    public function testLoadSuccessExtraBackwardSlashedPath()
    {
        $autoloader = new Autoloader(
            'FakeProject',
            dirname(__DIR__) . '/../Mocks/Common\\'
        );

        $this->assertTrue($autoloader->register());

        $someClass = new SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers CkanConsumer\Common\Autoloader::__construct
     * @covers CkanConsumer\Common\Autoloader::register
     * @covers CkanConsumer\Common\Autoloader::load
     * @covers CkanConsumer\Common\Autoloader::getPath
     */
    public function testLoadSuccessExtraMixedSlashedPath()
    {
        $autoloader = new Autoloader(
            'FakeProject',
            dirname(__DIR__) . '/../Mocks/Common\\\\/\\//'
        );

        $this->assertTrue($autoloader->register());

        $someClass = new SomeClass();

        $this->assertTrue($someClass->isLoaded());
    }

    /**
     * @covers CkanConsumer\Common\Autoloader::__construct
     * @covers CkanConsumer\Common\Autoloader::register
     * @covers CkanConsumer\Common\Autoloader::load
     * @covers CkanConsumer\Common\Autoloader::getPath
     */
    public function testLoadUnknownClass()
    {
        $autoloader = new Autoloader(
            'FakeProject',
            dirname(__DIR__) . '/../Mocks/Common\\\\/\\//'
        );

        $this->assertTrue($autoloader->register());

        $this->assertNull($autoloader->load('IDontExistClass'));
    }

    /**
     * @covers CkanConsumer\Common\Autoloader::__construct
     * @covers CkanConsumer\Common\Autoloader::register
     * @covers CkanConsumer\Common\Autoloader::load
     */
    public function testLoadClassFromUnknownNamespace()
    {
        $autoloader = new Autoloader(
            'FakeProject',
            dirname(__DIR__) . '/../Mocks/Common\\\\/\\//'
        );

        $this->assertTrue($autoloader->register());

        $this->assertNull($autoloader->load('\\UnknownNamespace\\IDontExistClass'));
    }

    /**
     * @covers CkanConsumer\Common\Autoloader::__construct
     * @covers CkanConsumer\Common\Autoloader::register
     * @covers CkanConsumer\Common\Autoloader::load
     * @covers CkanConsumer\Common\Autoloader::getPath
     */
    public function testLoadUnknownClassStacked()
    {
        $autoloader = new Autoloader(
            'OtherFakeProject',
            dirname(__DIR__) . '/../Mocks/Common\\\\/\\//'
        );

        $this->assertTrue($autoloader->register());

        $autoloader = new Autoloader(
            'FakeProject',
            dirname(__DIR__) . '/../Mocks/Common\\\\/\\//'
        );

        $this->assertTrue($autoloader->register());

        $this->assertNull($autoloader->load('IDontExistClass'));
    }
}
