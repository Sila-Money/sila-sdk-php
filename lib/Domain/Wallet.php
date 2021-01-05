<?php

/**
 * Wallet
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Wallet
 * Class used in the register wallet method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Walter Zelada <wzelada@digitalgeko.com>
 */
class Wallet
{
    /**
     * @var string
     * @Type("string")
     */
    private $blockchain_address;

    /**
     * @var string
     * @Type("string")
     */
    private $blockchain_network;

    /**
     * @var string
     * @Type("string")
     */
    private $nickname;

    /**
     * Constructor for Wallet object
     * @param string $blockchain_address
     * @param string $blockchain_network
     * @param string $nickname
     */
    public function __construct(
        string $blockchain_address,
        string $blockchain_network,
        string $nickname
    ) {
        $this->blockchain_address = $blockchain_address;
        $this->blockchain_network = $blockchain_network;
        $this->nickname = $nickname;
    }

    public function getBlockchainAddress(): string
    {
        return $this->blockchain_address;
    }
}
