<?php

/**
 * Transfer Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Transfer Response
 * Response used for transfer endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class TransferResponse extends OperationResponse
{
    /**
     * @var bool
     * @Type("bool")
     */
     private $success;

    /**
     * @var string
     * @Type("string")
     */
    private $destinationAddress;

    public function getDestinationAddress(): string
    {
        return $this->destinationAddress;
    }
}