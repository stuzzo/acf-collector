<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Definition;

// To use as default template
$definition = new Definition();

$definition
->setAutowired(true)
->setAutoconfigured(true)
->setPublic(true)
;

// $this is a reference to the current loader
$this->registerClasses($definition, 'ACFFormatter\\', '../src/*', '../src/{admin,exception,formatter,handler,I18N,includes,public}');