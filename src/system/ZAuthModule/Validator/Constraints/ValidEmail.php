<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\ZAuthModule\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidEmail extends Constraint
{
    public $message = 'The email "%string%" is invalid.';

    public $excludedUid;

    public function validatedBy()
    {
        return 'zikula.zauth.email.validator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOption()
    {
        return 'excludedUid';
    }
}
