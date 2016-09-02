<?php

namespace Dyvelop\CurrentUserBundle\Tests\Security;

use Dyvelop\CurrentUserBundle\Security\CurrentUserAware;
use Dyvelop\CurrentUserBundle\Security\CurrentUserProvider;
use Dyvelop\CurrentUserBundle\Security\CurrentUserTrait;
use Dyvelop\CurrentUserBundle\Tests\AbstractTestCase;
use Symfony\Component\Security\Core\User\User;

/**
 * Testing the current user aware interface and trait
 */
class CurrentUserAwareTest extends AbstractTestCase
{

    /**
     * @var CurrentUserAwareMock
     */
    protected $currentUserAware;


    /**
     * Set up tests
     */
    protected function setUp()
    {
        $this->currentUserAware = new CurrentUserAwareMock();
    }


    /**
     * Test initiating current user aware interface
     */
    public function testInit()
    {
        $this->assertInstanceOf(CurrentUserAware::class, $this->currentUserAware);
    }


    /**
     * Test setting current user provider
     */
    public function testSetCurrentUserProvider()
    {
        $provider = $this->getCurrentUserProviderStub();
        $this->currentUserAware->setCurrentUserProvider($provider);

        $reflection = new \ReflectionObject($this->currentUserAware);
        $property = $reflection->getProperty('currentUserProvider');
        $property->setAccessible(true);
        $this->assertEquals($provider, $property->getValue($this->currentUserAware));
    }


    /**
     * Test getting current user when logged in
     */
    public function testGetCurrentUser()
    {
        $expected = new User('username', 'password');
        $provider = $this->getCurrentUserProviderStub();
        $provider->expects($this->once())->method('getUser')->willReturn($expected);
        $this->currentUserAware->setCurrentUserProvider($provider);

        $result = $this->currentUserAware->getCurrentUser();
        $this->assertEquals($expected, $result);

    }


    /**
     * Test getting current user which is null
     */
    public function testGetCurrentUserNull()
    {
        $provider = $this->getCurrentUserProviderStub();
        $provider->expects($this->once())->method('getUser')->willReturn(null);
        $this->currentUserAware->setCurrentUserProvider($provider);

        $result = $this->currentUserAware->getCurrentUser();
        $this->assertNull($result);
    }


    /**
     * Get current user provider stub
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|CurrentUserProvider
     */
    protected function getCurrentUserProviderStub()
    {
        $provider = $this->getMockBuilder(CurrentUserProvider::class)->disableOriginalConstructor()->getMock();

        return $provider;
    }
}

class CurrentUserAwareMock implements CurrentUserAware
{
    use CurrentUserTrait;
}
