<?php

/**
 * Unlink Business Member Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Unlink Business Member Message
 * Object used in the link_business_member endpoint
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class UnlinkBusinessMemberMessage
{
    /**
     * @var \Silamoney\Client\Domain\HeaderBusiness
     * @Type("Silamoney\Client\Domain\HeaderBusiness")
     */
    protected $header;

    /**
     * @var string
     * @Type("string")
     */
    protected $role;

    /**
     * @var string
     * @Type("string")
     */
    protected $roleUuid;

    /**
     * @param string $appHandle
     * @param string $businessHandle
     * @param string $userHandle
     * @param string|null $role
     * @param string|null $roleUuid
     * @return \Silamoney\Client\Domain\LinkBusinessMemberMessage
     */
    public function __construct(
        string $appHandle,
        string $businessHandle,
        string $userHandle,
        string $role = null,
        string $roleUuid = null
    ) {
        $this->header = new HeaderBusiness($appHandle, $userHandle, $businessHandle);
        $this->role = $role;
        $this->roleUuid = $roleUuid;
    }
}
