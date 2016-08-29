<?php

namespace Dyvelop\CurrentUserBundle\Tests;

use Dyvelop\CurrentUserBundle\Security\CurrentUserProvider;

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
     * @return \PHPUnit_Framework_MockObject_MockObject|CurrentUserProvider
     */
    protected function getCurrentUserProviderStub()
    {
        $provider = $this->getMockBuilder('Dyvelop\CurrentUserBundle\Security\CurrentUserProvider')
            ->disableOriginalConstructor()
            ->getMock();

        return $provider;
    }
}
