<?php

/**
 * Update Wallet Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Update Wallet Message
 * Object sent in the update wallet method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Walter Zelada <wzelada@digitalgeko.com>
 */
class UpdateWalletMessage implements ValidInterface
{
    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    /**
     * @var string
     * @Type("string")
     */
    private $nickname;


    /**
     * @var boolean
     * @Type("boolean")
     */
    private $default;


    /**
     ** Constructor for UpdateWalletMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param string $nickname
     * @param boolean $default
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        ?string $nickname,
        ?bool $default
    ) {
        $this->nickname = $nickname;
        $this->default = $default;
        $this->header = new Header($appHandle, $userHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header);
    }
}
