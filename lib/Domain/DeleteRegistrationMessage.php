<?php

/**
 * Delete Registration Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Delete Registration Message
 * Object used as the message in delete/<registration-data> endpoints.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class DeleteRegistrationMessage extends HeaderBaseMessage
{
    /**
     * @var string
     * @Type("string")
     */
    private $uuid;

    /**
     * Constructor for Delete Registration Message object.
     * @param string $appHandle
     * @param string $userHandle
     * @param string $uuid
     * @return \Silamoney\Client\Domain\DeleteRegistrationMessage
     */
    public function __construct(string $appHandle, string $userHandle, string $uuid)
    {
        parent::__construct($appHandle, $userHandle);
        $this->uuid = $uuid;
    }
}
