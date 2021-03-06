<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\ExtensionsModule\Api;

use Zikula\ExtensionsModule\Api\ApiInterface\CapabilityApiInterface;
use Zikula\ExtensionsModule\Constant;
use Zikula\ExtensionsModule\Entity\ExtensionEntity;
use Zikula\ExtensionsModule\Entity\RepositoryInterface\ExtensionRepositoryInterface;
use Zikula\ExtensionsModule\Entity\Repository\ExtensionRepository;

/**
 * Class CapabilityApi
 */
class CapabilityApi implements CapabilityApiInterface
{
    /**
     * @var ExtensionRepository
     */
    private $extensionRepository;

    /**
     * @var ExtensionEntity[]
     */
    private $extensionsByCapability = [];

    /**
     * @var ExtensionEntity[]
     */
    private $extensionsByName = [];

    /**
     * Capability constructor.
     * @param ExtensionRepositoryInterface $extensionRepository
     */
    public function __construct(ExtensionRepositoryInterface $extensionRepository)
    {
        $this->extensionRepository = $extensionRepository;
    }

    /**
     * Load extensions into private property cache.
     */
    private function load()
    {
        $extensions = $this->extensionRepository->findBy(['state' => Constant::STATE_ACTIVE]);
        /** @var ExtensionEntity $extension */
        foreach ($extensions as $extension) {
            foreach ($extension->getCapabilities() as $capability => $definition) {
                $this->extensionsByCapability[$capability][] = $extension;
            }
            $this->extensionsByName[$extension->getName()] = $extension;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensionsCapableOf($capability)
    {
        if (empty($this->extensionsByCapability[$capability])) {
            $this->load();
        }

        return !empty($this->extensionsByCapability[$capability]) ? $this->extensionsByCapability[$capability] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function isCapable($extensionName, $requestedCapability)
    {
        if (empty($this->extensionsByName[$extensionName])) {
            $this->extensionsByName[$extensionName] = $this->extensionRepository->findOneBy(['name' => $extensionName]);
        }
        $capabilities = $this->extensionsByName[$extensionName]->getCapabilities();

        return array_key_exists($requestedCapability, $capabilities)
            ? $capabilities[$requestedCapability]
            : false;
    }

    /**
     * {@inheritdoc}
     */
    public function getCapabilitiesOf($extensionName)
    {
        if (empty($this->extensionsByName[$extensionName])) {
            $this->extensionsByName[$extensionName] = $this->extensionRepository->findOneBy(['name' => $extensionName]);
        }

        return $this->extensionsByName[$extensionName]->getCapabilities();
    }
}
