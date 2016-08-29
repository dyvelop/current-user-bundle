<?php

namespace Dyvelop\CurrentUserBundle\Tests\Annotation;

use Doctrine\Common\Annotations\Reader;
use Dyvelop\CurrentUserBundle\Annotation\CurrentUserDriver;
use Dyvelop\CurrentUserBundle\Tests\AbstractTestCase;

/**
 * Class CurrentUserDriverTest
 *
 * @package Dyvelop\CurrentUserBundle\Tests\Annotation
 */
class CurrentUserDriverTest extends AbstractTestCase
{

    /**
     * @var CurrentUserDriver
     */
    protected $driver;


    /**
     * Set up tests
     */
    protected function setUp()
    {
        parent::setUp();
        $this->driver = new CurrentUserDriver($this->getAnnotationReaderStub(), $this->getCurrentUserProviderStub());
    }


    /**
     * Test initiating current user driver
     */
    protected function testInit()
    {
        $this->assertInstanceOf('Dyvelop\CurrentUserBundle\Annotation\CurrentUserDriver', $this->driver);
    }


    /**
     * Get annotation reader stub
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Reader
     */
    protected function getAnnotationReaderStub()
    {
        $reader = $this->getMock('Doctrine\Common\Annotations\Reader');

        return $reader;
    }
}
