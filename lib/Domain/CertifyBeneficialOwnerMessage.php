<?php

/**
 * Certify Beneficial Owner Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Certify Beneficial Owner Message
 * Object used in the certify_beneficial_owner endpoint
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class CertifyBeneficialOwnerMessage extends BaseBusinessMessage
{
    /**
     * @var string
     * @Type("string")
     */
    private $memberHandle;

    /**
     * @var string
     * @Type("string")
     */
    private $certificationToken;

    /**
     * @param string $appHandle
     * @param string $userHandle
     * @param string $businessHandle
     * @param string $memberHandle
     * @param string $certificationToken
     * @return \Silamoney\Client\Domain\CertifyBeneficialOwnerMessage
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        string $businessHandle,
        string $memberHandle,
        string $certificationToken
    ) {
        parent::__construct($appHandle, $userHandle, $businessHandle);
        $this->memberHandle = $memberHandle;
        $this->certificationToken = $certificationToken;
    }
}
