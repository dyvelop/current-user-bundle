[![Build Status](https://travis-ci.org/dyvelop/current-user-bundle.svg?branch=master)](https://travis-ci.org/dyvelop/current-user-bundle)

# Dyvelop Current User Bundle

Symfony bundle to fetch the user which is currently logged in.

## Installation

### Step 1: Download

Download via [Composer](https://getcomposer.org/)

```bash
composer require dyvelop/current-user-bundle
```

### Step 2: Enable Bundle

Enable the Bundle in the `app/AppKernel.php` file in your Symfony project:

```php
// File: app/AppKernel.php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Dyvelop\CurrentUserBundle\DyvelopCurrentUserBundle(),
        );
        
        return $bundles;
    }
}
```

## Usage

### Current User Provider

Mainly this bundle implements a service named `dyvelop.current_user.provider` which provides the current user:

```php
// fetch current user (the result is NULL when no one is logged in)
$user = $this->container->get('dyvelop.current_user.provider')->getCurrentUser();
```

You may use the `CurrentUserAware` interface and `CurrentUserTrait` helper to inject it into any other service.

### Doctrine Annotation

Secondly, this bundle provides a Doctrine Annotation and Driver to inject the Current User into an entity via lifecycle callbacks:

```php
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dyvelop\CurrentUserBundle\Annotation as Dyvelop;

class Article
{
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=true)
     * @Dyvelop\CurrentUser(prePersist=true)
     */
    protected $author;
}
```

In this example the current user will be set automatically as author of an article before persisting it to the database.

Currently, only the `prePersist` and `preUpdate` lifecycle callbacks are implemented.
Feel free to contribute some more ;)
