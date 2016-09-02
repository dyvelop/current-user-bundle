<?php

namespace Dyvelop\CurrentUserBundle\Tests\Security;

use Dyvelop\CurrentUserBundle\Security\CurrentUserProvider;
use Dyvelop\CurrentUserBundle\Tests\AbstractTestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\User;

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
     * Test initiating current user provider
     */
    public function testInit()
    {
        $tokenStorage = $this->getSecurityTokenStub();
        $this->provider = new CurrentUserProvider($tokenStorage);
    }


    /**
     * Test if get user method without valid token will return null
     */
    public function testGetUserWithoutToken()
    {
        $tokenStorage = $this->getSecurityTokenStub();
        $tokenStorage->expects($this->once())->method('getToken')->willReturn(null);
        $this->provider = new CurrentUserProvider($tokenStorage);

        $result = $this->provider->getUser();
        $this->assertNull($result);
    }


    /**
     * Test if get user method not having a user object will return null
     */
    public function testGetUserForNonObject()
    {
        $token = $this->getMock(TokenInterface::class);
        $token->expects($this->once())->method('getUser')->willReturn('Anonymous');
        $tokenStorage = $this->getSecurityTokenStub();
        $tokenStorage->expects($this->once())->method('getToken')->willReturn($token);
        $this->provider = new CurrentUserProvider($tokenStorage);

        $result = $this->provider->getUser();
        $this->assertNull($result);
    }


    /**
     * Test if get user method returns object
     */
    public function testGetUser()
    {
        $expected = new User('username', 'password');
        $token = $this->getMock(TokenInterface::class);
        $token->expects($this->once())->method('getUser')->willReturn($expected);
        $tokenStorage = $this->getSecurityTokenStub();
        $tokenStorage->expects($this->once())->method('getToken')->willReturn($token);
        $this->provider = new CurrentUserProvider($tokenStorage);

        $result = $this->provider->getUser();
        $this->assertEquals($expected, $result);
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
