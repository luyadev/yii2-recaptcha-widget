<?php

namespace luyadev\recaptcha\tests;

use luyadev\recaptcha\ReCaptchaValidator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ReCaptchaValidatorTest extends TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $validatorClass;

    /** @var \ReflectionMethod */
    private $validatorMethod;

    public function testValidateValueSuccess()
    {
        $this->validatorClass
            ->expects($this->once())
            ->method('getResponse')
            ->willReturn(['success' => true, 'hostname' => 'localhost']);

        $this->assertNull($this->validatorMethod->invoke($this->validatorClass, 'test'));
        $this->assertNull($this->validatorMethod->invoke($this->validatorClass, 'test'));
    }

    public function testValidateValueFailure()
    {
        $this->validatorClass
            ->expects($this->once())
            ->method('getResponse')
            ->willReturn(['success' => false, 'hostname' => 'localhost']);

        $this->assertNotNull($this->validatorMethod->invoke($this->validatorClass, 'test'));
        $this->assertNotNull($this->validatorMethod->invoke($this->validatorClass, 'test'));
    }

    public function testValidateValueException()
    {
        $this->validatorClass
            ->expects($this->once())
            ->method('getResponse')
            ->willReturn([]);

        $this->expectException('yii\base\Exception');
        $this->validatorMethod->invoke($this->validatorClass, 'test');
    }

    public function testHostNameValidateFailure()
    {
        $this->validatorClass
            ->expects($this->once())
            ->method('getResponse')
            ->willReturn(['success' => false, 'hostname' => 'localhost']);
        $this->validatorClass
            ->expects($this->once())
            ->method('getHostName')
            ->willReturn('test');
        $this->validatorClass->checkHostName = true;

        $this->expectException('yii\base\Exception');
        $this->validatorMethod->invoke($this->validatorClass, 'test');
    }

    public function testHostNameValidateSuccess()
    {
        $this->validatorClass
            ->expects($this->once())
            ->method('getResponse')
            ->willReturn(['success' => false, 'hostname' => 'localhost']);
        $this->validatorClass
            ->expects($this->once())
            ->method('getHostName')
            ->willReturn('localhost');
        $this->validatorClass->checkHostName = true;

        $this->validatorMethod->invoke($this->validatorClass, 'test');
    }

    public function setUp() : void
    {
        parent::setUp();
        $this->validatorClass = $this->getMockBuilder(ReCaptchaValidator::className())
            ->disableOriginalConstructor()
            ->setMethods(['getResponse', 'getHostName'])
            ->getMock();

        $this->validatorMethod = (new ReflectionClass(ReCaptchaValidator::className()))->getMethod('validateValue');
        $this->validatorMethod->setAccessible(true);
    }
}
