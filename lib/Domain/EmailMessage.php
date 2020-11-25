<?php

/**
 * Email Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Email Message
 * Object used as the message in [add|update]/email endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class EmailMessage extends RegistrationDataBaseMessage
{
    /**
     * @var string
     * @Type("string")
     */
    private $email;

    /**
     * Constructor for Add Email Message object.
     * @param string $appHandle
     * @param string $userHandle
     * @param string|null $email
     * @param string|null $uuid
     * @return \Silamoney\Client\Domain\AddEmailMessage
     */
    public function __construct(string $appHandle, string $userHandle, ?string $email = null, ?string $uuid = null)
    {
        parent::__construct($appHandle, $userHandle, $uuid);
        $this->email = $email;
    }
}
