<?php

/**
 * Crypto Entry
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Crypto Entry
 * Object used in the entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class CryptoEntry
{
    /**
     * @var string
     * @Type("string")
     */
    private $cryptoAlias;

    /**
     * @var string
     * @Type("string")
     */
    private $cryptoAddress;

    /**
     * @var string
     * @Type("string")
     */
    private $cryptoCode;

    /**
     * Constructor for the CryptoEntry object.
     *
     * @param Silamoney\Client\Domain\User $user
     */
    public function __construct(User $user)
    {
        $this->cryptoAddress = $user->getCryptoAddress();
        $this->cryptoAlias = "";
        $this->cryptoCode = CryptoCode::ETH;
    }
}
