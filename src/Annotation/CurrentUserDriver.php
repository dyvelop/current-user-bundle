<?php

namespace Dyvelop\CurrentUserBundle\Annotation;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Dyvelop\CurrentUserBundle\Security\CurrentUserProvider;

/**
 * Driver for current user annotation
 */
class CurrentUserDriver
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var CurrentUserProvider
     */
    protected $currentUserProvider;


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
        if (null === $user = $this->currentUserProvider->getUser()) {
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
        if (null === $user = $this->currentUserProvider->getUser()) {
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
