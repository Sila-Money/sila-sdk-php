<?php

/**
 * Header
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Header
 * Object used in the multiple msg.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Header
{
    /**
     * @var string
     * @Type("string")
     */
    private $reference;

    /**
     * @var int
     * @Type("int")
     */
    private $created;

    /**
     * @var string
     * @Type("string")
     */
    private $userHandle;

    /**
     * @var string
     * @Type("string")
     */
    private $authHandle;

    /**
     * @var string
     * @Type("string")
     */
    private $version;

    /**
     * @var string
     * @Type("string")
     */
    private $crypto;

    /**
     * Constructor for header object.
     *
     * @param string $userHandle
     * @param string $appHandle
     */
    public function __construct(string $userHandle, string $appHandle)
    {
        $this->authHandle = $appHandle;
        $this->userHandle = $userHandle;
        $this->created = time() - 100;
        $this->crypto = CryptoCode::ETH;
        $this->reference = strval(rand(0, 1000000));
        $this->version = Version::ZERO_2;
    }
}
