<?php

/**
 * Add Email Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Add Email Message
 * Object used as the message in add/email endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class AddEmailMessage extends HeaderBaseMessage
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
     * @param string $email
     * @return \Silamoney\Client\Domain\AddEmailMessage
     */
    public function __construct(string $appHandle, string $userHandle, string $email)
    {
        parent::__construct($appHandle, $userHandle);
        $this->email = $email;
    }
}
