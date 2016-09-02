<?php

namespace Dyvelop\CurrentUserBundle\Annotation;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Dyvelop\CurrentUserBundle\Security\CurrentUserAware;
use Dyvelop\CurrentUserBundle\Security\CurrentUserProvider;
use Dyvelop\CurrentUserBundle\Security\CurrentUserTrait;

/**
 * Driver for current user annotation
 */
class CurrentUserDriver implements CurrentUserAware
{
    /**
     * Import standard implementation of the current user aware interface
     */
    use CurrentUserTrait;

    /**
     * @var Reader
     */
    protected $reader;


    /**
     * Constructor
     *
     * @param Reader              $reader   Annotation reader
     * @param CurrentUserProvider $provider Current user provider
     */
    public function __construct(Reader $reader, CurrentUserProvider $provider)
    {
        $this->reader = $reader;
        $this->currentUserProvider = $provider;
    }


    /**
     * Set current user on pre-persist event
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        // no user is logged in
        if (null === $user = $this->getCurrentUser()) {
            return;
        }

        $entity = $args->getEntity();

        $reflection = new \ReflectionObject($entity);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $annotation = $this->reader->getPropertyAnnotation($property, CurrentUser::class);
            if (!$annotation instanceof CurrentUser || !$annotation->prePersist) {
                continue;
            }

            // set current user
            $property->setAccessible(true);
            $property->setValue($entity, $user);
            break;
        }
    }


    /**
     * Set current user on pre-update event
     *
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        if (null === $user = $this->getCurrentUser()) {
            return;
        }

        $entity = $args->getEntity();

        $reflection = new \ReflectionObject($entity);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $annotation = $this->reader->getPropertyAnnotation($property, CurrentUser::class);
            if (!$annotation instanceof CurrentUser || !$annotation->preUpdate) {
                continue;
            }

            // set current user
            $property->setAccessible(true);
            $property->setValue($entity, $user);
            break;
        }
    }
}
