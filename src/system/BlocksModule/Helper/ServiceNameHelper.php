<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\BlocksModule\Helper;

use Symfony\Component\DependencyInjection\Container;

class ServiceNameHelper
{
    /**
     * Convert a class name to a standardized symfony service name
     *   'Acme\FooBundle\Bar\FooBar' => 'acme.foo_bundle.bar.foo_bar'
     * @param $classname
     * @return string
     */
    public function generateServiceNameFromClassName($classname)
    {
        $classname = str_replace(['\\'], '.', $classname);
        $classname = Container::underscore($classname);

        return trim($classname, "\\_. \t\n\r\0\x0B");
    }
}
