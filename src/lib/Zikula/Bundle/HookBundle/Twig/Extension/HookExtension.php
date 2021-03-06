<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\Bundle\HookBundle\Twig\Extension;

use Zikula\Bundle\HookBundle\Dispatcher\HookDispatcherInterface;
use Zikula\Bundle\HookBundle\Hook\DisplayHook;
use Zikula\Bundle\HookBundle\Hook\FilterHook;
use Zikula\Core\UrlInterface;

class HookExtension extends \Twig_Extension
{
    /**
     * @var HookDispatcherInterface
     */
    private $hookDispatcher;

    public function __construct(HookDispatcherInterface $hookDispatcher)
    {
        $this->hookDispatcher = $hookDispatcher;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('notifyDisplayHooks', [$this, 'notifyDisplayHooks'], ['is_safe' => ['html']])
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('notifyFilters', [$this, 'notifyFilters'], ['is_safe' => ['html']])
        ];
    }

    /**
     * @param $eventName
     * @param integer $id The object id
     * @param UrlInterface $urlObject
     * @param bool $outputAsArray set to true to output results as array (requires additional handling in template)
     *
     * @return bool|string|array
     */
    public function notifyDisplayHooks($eventName, $id = null, $urlObject = null, $outputAsArray = false)
    {
        if (empty($eventName)) {
            return trigger_error('Error! "eventname" must be set in notifydisplayhooks');
        }
        if ($urlObject && !($urlObject instanceof UrlInterface)) {
            return trigger_error('Error! "urlobject" must be an instance of Zikula\Core\UrlInterface');
        }

        // create event and notify
        $hook = new DisplayHook($id, $urlObject);
        $this->hookDispatcher->dispatch($eventName, $hook);
        $responses = $hook->getResponses();

        if ($outputAsArray) {
            return $responses;
        }

        $output = '';
        foreach ($responses as $result) {
            if (!empty($result)) {
                $output .= '<div class="z-displayhook">' . $result . '</div>' . "\n";
            }
        }

        return $output;
    }

    /**
     * @param $content
     * @param $filterEventName
     * @return mixed
     */
    public function notifyFilters($content, $filterEventName)
    {
        $hook = new FilterHook($content);

        return $this->hookDispatcher->dispatch($filterEventName, $hook)->getData();
    }
}
