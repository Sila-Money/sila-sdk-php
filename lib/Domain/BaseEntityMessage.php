<?php

/**
 * Entity
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Entity
 * Object used in the entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class BaseEntityMessage
{
    /**
     * @var \Silamoney\Client\Domain\Address
     * @Type("Silamoney\Client\Domain\Address")
     */
    protected $address;

    /**
     * @var \Silamoney\Client\Domain\Identity
     * @Type("Silamoney\Client\Domain\Identity")
     */
    protected $identity;

    /**
     * @var \Silamoney\Client\Domain\Contact
     * @Type("Silamoney\Client\Domain\Contact")
     */
    protected $contact;

    /**
     * @var \Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    protected $header;

    /**
     * @var \Silamoney\Client\Domain\CryptoEntry
     * @Type("Silamoney\Client\Domain\CryptoEntry")
     */
    protected $cryptoEntry;

    /**
     * @var string
     * @Type("string")
     */
    protected $message;

    /**
     * @param string $appHandle
     * @param \Silamoney\Client\Domain\BaseUser $user
     * @param \Silamoney\Client\Domain\IdentityAlias $identityAlias
     * @return \Silamoney\Client\Domain\BaseEntityMessage
     */
    public function __construct(string $appHandle, BaseUser $user, IdentityAlias $identityAlias)
    {
        $this->header = new Header($appHandle, $user->getHandle());
        $this->message = Message::ENTITY;
        $this->address = new Address($user);
        $this->identity = new Identity($user, $identityAlias);
        $this->contact = new Contact($user);
        $this->cryptoEntry = new CryptoEntry($user);
    }
}
