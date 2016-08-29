<?php

namespace Dyvelop\CurrentUserBundle\Annotation;

/**
 * Map the current user to an doctrine entity
 *
 * @Annotation
 */
class CurrentUser
{
    /**
     * Set attribute once on pre-persist event
     *
     * @var bool
     */
    public $prePersist;

    /**
     * Set attribute anew every time on pre-update event
     *
     * @var bool
     */
    public $preUpdate;
}
