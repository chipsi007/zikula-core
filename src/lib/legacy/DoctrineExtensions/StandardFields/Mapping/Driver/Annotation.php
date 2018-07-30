<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - https://ziku.la/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineExtensions\StandardFields\Mapping\Driver;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Gedmo\Exception\InvalidMappingException;
use Gedmo\Mapping\Driver\AnnotationDriverInterface;

/**
 * @deprecated remove in Core-2.0
 * This is an annotation mapping driver for StandardFields
 * behavioral extension. Used for extraction of extended
 * metadata from Annotations specificaly for StandardFields
 * extension.
 */
class Annotation implements AnnotationDriverInterface
{
    /**
     * Annotation field is timestampable
     */
    const TIMESTAMPABLE = 'DoctrineExtensions\\StandardFields\\Mapping\\Annotation\\StandardFields';

    /**
     * List of types which are valid for timestamp
     *
     * @var array
     */
    private $validTypes = [
        'integer'
    ];

    /**
     * Annotation reader instance
     *
     * @var object
     */
    private $reader;

    /**
     * original driver if it is available
     */
    protected $_originalDriver = null;

    /**
     * {@inheritdoc}
     */
    public function setAnnotationReader($reader)
    {
        @trigger_error('StandardFields extension is deprecated, please use Blameable and Timestampable instead.', E_USER_DEPRECATED);

        $this->reader = $reader;
    }

    /**
     * {@inheritdoc}
     */
    public function validateFullMetadata(ClassMetadata $meta, array $config)
    {
        @trigger_error('StandardFields extension is deprecated, please use Blameable and Timestampable instead.', E_USER_DEPRECATED);
    }

    /**
     * {@inheritdoc}
     */
    public function readExtendedMetadata($meta, array &$config)
    {
        @trigger_error('StandardFields extension is deprecated, please use Blameable and Timestampable instead.', E_USER_DEPRECATED);

        $class = $meta->getReflectionClass();
        // property annotations
        foreach ($class->getProperties() as $property) {
            if ($meta->isMappedSuperclass && !$property->isPrivate() ||
                $meta->isInheritedField($property->name) ||
                isset($meta->associationMappings[$property->name]['inherited'])
            ) {
                continue;
            }
            if ($timestampable = $this->reader->getPropertyAnnotation($property, self::TIMESTAMPABLE)) {
                $field = $property->getName();
                if (!$meta->hasField($field)) {
                    throw new InvalidMappingException("Unable to find StandardFields [{$field}] as mapped property in entity - {$meta->name}");
                }
                if (!$this->isValidField($meta, $field)) {
                    throw new InvalidMappingException("Field - [{$field}] type is not valid and must be 'integer' in class - {$meta->name}");
                }
                if ('userid' != $timestampable->type) {
                    throw new InvalidMappingException("Field - [{$field}] StandardFields annotation attribute 'type' is not 'userid' in class - {$meta->name}");
                }
                if (!in_array($timestampable->on, ['update', 'create', 'change'])) {
                    throw new InvalidMappingException("Field - [{$field}] trigger 'on' is not one of [update, create, change] in class - {$meta->name}");
                }
                if ('change' == $timestampable->on) {
                    if (!isset($timestampable->field) || !isset($timestampable->value)) {
                        throw new InvalidMappingException("Missing parameters on property - {$field}, field and value must be set on [change] trigger in class - {$meta->name}");
                    }
                    $field = [
                        'field'        => $field,
                        'trackedField' => $timestampable->field,
                        'value'        => $timestampable->value
                    ];
                }
                // properties are unique and mapper checks that, no risk here
                $config[$timestampable->on][] = $field;
            }
        }
    }

    /**
     * Checks if $field type is valid
     *
     * @param ClassMetadata $meta
     * @param string        $field
     *
     * @return boolean
     */
    protected function isValidField(ClassMetadata $meta, $field)
    {
        $mapping = $meta->getFieldMapping($field);

        return $mapping && in_array($mapping['type'], $this->validTypes);
    }

    /**
     * Passes in the mapping read by original driver
     *
     * @param $driver
     *
     * @return void
     */
    public function setOriginalDriver($driver)
    {
        @trigger_error('StandardFields extension is deprecated, please use Blameable and Timestampable instead.', E_USER_DEPRECATED);

        $this->_originalDriver = $driver;
    }
}
