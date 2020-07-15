<?php

/**
 * Business Entity Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Business Entity Message
 * Object sent in the register endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class BusinessEntityMessage extends BaseEntityMessage
{
    /**
     * @var \Silamoney\Client\Domain\BusinessEntity
     * @Type("Silamoney\Client\Domain\BusinessEntity")
     */
    private $entity;

    /**
     * Constructor for the BaseEntityMessage object.
     *
     * @param string $appHandle
     * @param \Silamoney\Client\Domain\BusinessUser $user
     * @return \Silamoney\Client\Domain\BusinessEntityMessage
     */
    public function __construct(string $appHandle, BusinessUser $user)
    {
        parent::__construct($appHandle, $user, IdentityAlias::EIN());
        $this->entity = new BusinessEntity($user);
    }
}
