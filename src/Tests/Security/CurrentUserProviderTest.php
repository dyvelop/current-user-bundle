<?php

namespace Dyvelop\CurrentUserBundle\Tests\Security;

use Dyvelop\CurrentUserBundle\Security\CurrentUserProvider;
use Dyvelop\CurrentUserBundle\Tests\AbstractTestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class CurrentUserProviderTest
 *
 * @package Dyvelop\CurrentUserBundle\Tests\Security
 */
class CurrentUserProviderTest extends AbstractTestCase
{
    /**
     * @var CurrentUserProvider
     */
    protected $provider;


    /**
     * Set up tests
     */
    protected function setUp()
    {
        parent::setUp();
        $this->provider = new CurrentUserProvider($this->getSecurityTokenStub());
    }


    /**
     * Test initiating current user provider
     */
    public function testInit()
    {
        $this->assertInstanceOf('Dyvelop\CurrentUserBundle\Security\CurrentUserProvider', $this->provider);
    }


    /**
     * Get security token stub
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|TokenStorageInterface
     */
    protected function getSecurityTokenStub()
    {
        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface');

        return $token;
    }
}
