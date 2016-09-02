<?php

namespace Dyvelop\CurrentUserBundle\Security;

use Symfony\Component\Security\Core\User\User;

/**
 * Interface for injecting the current user in a service
 */
interface CurrentUserAware
{
    /**
     * Get user which is currently logged in
     * Can be null if the user is anonymous
     *
     * @return null|User
     */
    public function getCurrentUser();


    /**
     * Set current user provider
     *
     * @param CurrentUserProvider $provider
     */
    public function setCurrentUserProvider(CurrentUserProvider $provider);
}
