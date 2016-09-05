<?php

namespace Dyvelop\CurrentUserBundle\Tests\Annotation;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Dyvelop\CurrentUserBundle\Annotation as Dyvelop;
use Dyvelop\CurrentUserBundle\Annotation\CurrentUserDriver;
use Dyvelop\CurrentUserBundle\Tests\AbstractTestCase;
use Symfony\Component\Security\Core\User\User;

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
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $reader;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $provider;


    /**
     * Set up tests
     */
    protected function setUp()
    {
        parent::setUp();
        $this->reader = new AnnotationReader();
        $this->provider = $this->getCurrentUserProviderStub();
        $this->driver = new CurrentUserDriver($this->reader, $this->provider);
    }


    /**
     * Test initiating current user driver
     */
    public function testInit()
    {
        $this->assertInstanceOf(CurrentUserDriver::class, $this->driver);
    }


    /**
     * Test pre-persist
     */
    public function testPrePersist()
    {
        $user = new User('username', 'password');
        $this->provider->expects($this->once())->method('getUser')->willReturn($user);

        $entity = new CurrentUserEntity();
        $args = $this->getMockBuilder(LifecycleEventArgs::class)->disableOriginalConstructor()->getMock();
        $args->expects($this->once())->method('getEntity')->willReturn($entity);

        $this->driver->prePersist($args);
        $this->assertEquals($user, $entity->currentUser);
        $this->assertEquals($user, $entity->getPrePersistOnly());
        $this->assertNull($entity->getPreUpdateOnly());
    }


    /**
     * Test pre-update
     */
    public function testPreUpdate()
    {
        $user = new User('username', 'password');
        $this->provider->expects($this->once())->method('getUser')->willReturn($user);

        $entity = new CurrentUserEntity();
        $args = $this->getMockBuilder(LifecycleEventArgs::class)->disableOriginalConstructor()->getMock();
        $args->expects($this->once())->method('getEntity')->willReturn($entity);

        $this->driver->preUpdate($args);
        $this->assertEquals($user, $entity->currentUser);
        $this->assertNull($entity->getPrePersistOnly());
        $this->assertEquals($user, $entity->getPreUpdateOnly());
    }
}

class CurrentUserEntity
{
    /**
     * @var User
     * @Dyvelop\CurrentUser(prePersist=true, preUpdate=true)
     */
    public $currentUser;

    /**
     * @var User
     * @Dyvelop\CurrentUser(prePersist=true)
     */
    protected $prePersistOnly;

    /**
     * @var User
     * @Dyvelop\CurrentUser(preUpdate=true)
     */
    private $preUpdateOnly;


    /**
     * @return User
     */
    public function getPrePersistOnly()
    {
        return $this->prePersistOnly;
    }


    /**
     * @return User
     */
    public function getPreUpdateOnly()
    {
        return $this->preUpdateOnly;
    }
}
