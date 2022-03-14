<?php

/**
 * Get Retry Webhook Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Get Retry Webhook Message
 * Object sent in the Get retry_webhook method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class RetryWebhookMessage implements ValidInterface
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
    private $eventUuid;

    /**
     * Constructor for GetTransactionMsg object.
     *
     * @param string $appHandle
     * @param string $eventUuid
     */
    public function __construct(
        string $appHandle,
        string $eventUuid
    ) {
        $this->header = new Header($appHandle);
        $this->eventUuid = $eventUuid;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header);
    }
}
