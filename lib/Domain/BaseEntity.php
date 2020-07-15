<?php

/**
 * Base Entity
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Base Entity
 * Object used in the entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class BaseEntity
{
    /**
     * @var string
     * @Type("string")
     */
    protected $entityName;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param string $entityName
     * @param string|null $entityType
     * @return \Silamoney\Client\Domain\BaseEntity
     */
    protected function __construct(string $entityName, string $entityType = null)
    {
        $this->entityName = $entityName;
        $this->type = $entityType;
    }
}
