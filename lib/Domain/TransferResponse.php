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
     * @var string
     * @Type("string")
     */
    public $destinationAddress;

    public function getDestinationAddress(): string
    {
        return $this->destinationAddress;
    }
}
