<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\AdminModule\Twig\Extension\SimpleFunction;

use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;

class AdminBreadcrumbsFunction
{
    /**
     * @var FragmentHandler
     */
    private $handler;

    /**
     * AdminBreadcrumbsFunction constructor.
     * @param FragmentHandler $handler
     */
    public function __construct(FragmentHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Inserts admin breadcrumbs.
     *
     * This has NO configuration options.
     *
     * Examples:
     *
     * <samp>{{ adminBreadcrumbs() }}</samp>
     *
     * @return string
     */
    public function display()
    {
        $ref = new ControllerReference('ZikulaAdminModule:AdminInterface:breadcrumbs');

        return $this->handler->render($ref, 'inline', []);
    }
}
