<?php

/**
 * Entity Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Entity Message
 * Object sent in the register endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class EntityMessage extends BaseEntityMessage implements ValidInterface
{
    /**
     * @var \Silamoney\Client\Domain\Entity
     * @Type("Silamoney\Client\Domain\Entity")
     */
    private $entity;

    /**
     * Constructor for the EntityMessage object.
     *
     * @param \Silamoney\Client\Domain\User $user
     * @param string $appHandle
     * @return \Silamoney\Client\Domain\EntityMessage
     */
    public function __construct(User $user, string $appHandle)
    {
        parent::__construct($appHandle, $user, IdentityAlias::SSN());
        $this->entity = new Entity($user);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && v::notOptional()->validate($this->address)
            && $this->address->isValid()
            && v::notOptional()->validate($this->identity)
            && $this->identity->isValid()
            && v::notOptional()->validate($this->contact)
            && $this->contact->isValid()
            && v::notOptional()->validate($this->cryptoEntry)
            && $this->cryptoEntry->isValid()
            && v::notOptional()->validate($this->entity)
            && $this->entity->isValid();
    }
}
