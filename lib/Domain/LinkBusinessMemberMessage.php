<?php

/**
 * Link Business Member Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Link Business Member Message
 * Object used in the link_business_member endpoint
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class LinkBusinessMemberMessage extends UnlinkBusinessMemberMessage
{
    /**
     * @var float
     * @Type("float")
     */
    private $ownershipStake;

    /**
     * @var string
     * @Type("string")
     */
    private $memberHandle;

    /**
     * @var string
     * @Type("string")
     */
    private $details;

    /**
     * @param string $appHandle
     * @param string $businessHandle
     * @param string $userHandle
     * @param string|null $role
     * @param string|null $roleUuid
     * @param float|null $ownershipStake
     * @param string|null $memberHandle
     * @param string|null $details
     * @return \Silamoney\Client\Domain\LinkBusinessMemberMessage
     */
    public function __construct(
        string $appHandle,
        string $businessHandle,
        string $userHandle,
        string $role = null,
        string $roleUuid = null,
        float $ownershipStake = null,
        string $memberHandle = null,
        string $details = null
    ) {
        parent::__construct($appHandle, $businessHandle, $userHandle, $role, $roleUuid);
        $this->ownershipStake = $ownershipStake;
        $this->memberHandle = $memberHandle;
        $this->details = $details;
    }
}
