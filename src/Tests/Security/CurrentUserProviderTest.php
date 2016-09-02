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
        $this->assertInstanceOf(CurrentUserProvider::class, $this->provider);
    }


    /**
     * Test if get user method without valid token will return null
     */
    public function testGetUserWithoutToken()
    {
        // TODO Implement!
        $this->markTestIncomplete('TODO Implement!');
    }


    /**
     * Test if get user method not having a user object will return null
     */
    public function testGetUserForNonObject()
    {
        // TODO Implement!
        $this->markTestIncomplete('TODO Implement!');
    }


    /**
     * Test if get user method returns object
     */
    public function testGetUser()
    {
        // TODO Implement!
        $this->markTestIncomplete('TODO Implement!');
    }


    /**
     * Get security token stub
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|TokenStorageInterface
     */
    protected function getSecurityTokenStub()
    {
        $token = $this->getMock(TokenStorageInterface::class);

        return $token;
    }
}
