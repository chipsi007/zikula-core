<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\Core\Response\Ajax;

/**
 * Ajax class.
 */
class FatalResponse extends AbstractErrorResponse
{
    /**
     * Response code.
     *
     * @var integer
     */
    protected $statusCode = 500;

    /**
     * Flag to create a new nonce.
     *
     * @var boolean
     */
    protected $newCsrfToken = false;
}
