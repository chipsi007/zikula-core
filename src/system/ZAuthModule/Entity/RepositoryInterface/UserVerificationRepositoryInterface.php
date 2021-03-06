<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\ZAuthModule\Entity\RepositoryInterface;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;
use Zikula\ZAuthModule\Entity\UserVerificationEntity;
use Zikula\ZAuthModule\ZAuthConstant;

interface UserVerificationRepositoryInterface extends ObjectRepository, Selectable
{
    public function persistAndFlush(UserVerificationEntity $entity);

    public function removeAndFlush(UserVerificationEntity $entity);

    public function removeByZikulaId($uid);

    /**
     * @param integer $daysOld
     * @param int $changeType
     * @param bool $deleteUserEntities
     * @return array UserEntity[] records deleted
     */
    public function purgeExpiredRecords($daysOld, $changeType = ZAuthConstant::VERIFYCHGTYPE_REGEMAIL, $deleteUserEntities = true);

    public function resetVerifyChgFor($uid, $types = null);

    public function isVerificationEmailSent($uid);

    public function setVerificationCode($uid, $changeType = ZAuthConstant::VERIFYCHGTYPE_PWD, $hashedConfirmationCode = null, $email = null);
}
