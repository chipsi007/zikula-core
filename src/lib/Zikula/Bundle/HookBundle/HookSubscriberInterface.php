<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\Bundle\HookBundle;

/**
 * Interface HookSubscriberInterface
 *
 * Create a service that implements this interface and tag it with `zikula.hook_subscriber`
 * The tag must also include an `areaName` argument.
 */
interface HookSubscriberInterface extends HookInterface
{
    /**
     * Returns an array of hook types this subscriber will dispatch.
     *
     * The array keys are hook types and the value can be:
     *
     *  * The event name that will be dispatched: format: <module>.<category>.<area>.<type>
     *
     * For instance:
     *
     *  * array('hookType' => 'eventName')
     *
     * @return array The hook types and their names
     */
    public function getEvents();
}
