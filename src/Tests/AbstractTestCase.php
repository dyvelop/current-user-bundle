<?php

namespace Dyvelop\CurrentUserBundle\Tests;

use Dyvelop\CurrentUserBundle\Security\CurrentUserProvider;
use Symfony\Component\Security\Core\User\User;

/**
 * Abstract test case
 *
 * @package Dyvelop\CurrentUserBundle\Tests
 * @author  Franziska Dyckhoff <fdyckhoff@dyvelop.de>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Get current user provider stub
     *
     * @param User $user
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|CurrentUserProvider
     */
    protected function getCurrentUserProviderStub($user = null)
    {
        $provider = $this->getMockBuilder('Dyvelop\CurrentUserBundle\Security\CurrentUserProvider')
            ->disableOriginalConstructor()
            ->getMock();

        if (!is_null($user)) {
            $provider->expects($this->any())->method('getUser')->willReturn($user);
        }

        return $provider;
    }
}
