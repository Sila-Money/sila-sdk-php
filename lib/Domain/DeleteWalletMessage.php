<?php

/**
 * Delete Wallet Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Delete Wallet Message
 * Object sent in the delete wallet method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Walter Zelada <wzelada@digitalgeko.com>
 */
class DeleteWalletMessage implements ValidInterface
{
    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    /**
     ** Constructor for DeleteWalletMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     */
    public function __construct(
        string $userHandle,
        string $appHandle
    ) {
        $this->header = new Header($userHandle, $appHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header);
    }
}
