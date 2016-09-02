<?php

namespace Dyvelop\CurrentUserBundle\Security;

use Symfony\Component\Security\Core\User\User;

/**
 * Standard implementation of the current user aware interface
 */
trait CurrentUserTrait
{
    /**
     * @var CurrentUserProvider
     */
    protected $currentUserProvider;


    /**
     * Get user which is currently logged in
     * Can be null if the user is anonymous
     *
     * @return null|User
     */
    public function getCurrentUser()
    {
        return $this->currentUserProvider->getUser();
    }


    /**
     * Set current user provider
     *
     * @param CurrentUserProvider $provider
     */
    public function setCurrentUserProvider(CurrentUserProvider $provider)
    {
        $this->currentUserProvider = $provider;
    }
}
