<?php

/**
 * Entity Update Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use DateTime;
use JMS\Serializer\Annotation\Type;

/**
 * Entity Update Message
 * Object used as the message in update/entity endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class EntityUpdateMessage extends HeaderBaseMessage
{
    /**
     * @var ?string
     * @Type("string")
     */
    private $firstName;
    /**
     * @var ?string
     * @Type("string")
     */
    private $lastName;
    /**
     * @var ?string
     * @Type("string")
     */
    private $entityName;
    /**
     * @var ?string
     * @Type("string")
     */
    private $birthdate;
    /**
     * @var ?string
     * @Type("string")
     */
    private $businessType;
    /**
     * @var ?string
     * @Type("string")
     */
    private $naicsCode;
    /**
     * @var ?string
     * @Type("string")
     */
    private $doingBusinessAs;
    /**
     * @var ?string
     * @Type("string")
     */
    private $businessWebsite;
    /**
     * @var ?string
     * @Type("string")
     */
    private $registrationState;

    /**
     * Constructor for Entity Update Message object.
     * @param string $appHandle
     * @param string $userHandle
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $entityName
     * @param DateTime|null $birthDate
     * @param string|null $businessType
     * @param string|null $naicsCode
     * @param string|null $doingBusinessAs
     * @param string|null $businessWebsite
     * @param string|null $registrationState
     * @return \Silamoney\Client\Domain\EntityUpdateMessage
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $firstName = null,
        string $lastName = null,
        string $entityName = null,
        DateTime $birthdate = null,
        string $businessType = null,
        string $naicsCode = null,
        string $doingBusinessAs = null,
        string $businessWebsite = null,
        string $registrationState = null
    ) {
        parent::__construct($appHandle, $userHandle);
        $this->appHandle = $appHandle;
        $this->userHandle = $userHandle;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->entityName = $entityName;
        $this->birthdate = $birthdate ? $birthdate->format('Y-m-d') : null;
        $this->businessType = $businessType;
        $this->naicsCode = $naicsCode;
        $this->doingBusinessAs = $doingBusinessAs;
        $this->businessWebsite = $businessWebsite;
        $this->registrationState = $registrationState;
    }
}
