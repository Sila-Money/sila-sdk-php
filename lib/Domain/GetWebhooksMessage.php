<?php

/**
 * Get Webhooks Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Get Webhooks Message
 * Object sent in the Get Webhooks method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class GetWebhooksMessage implements ValidInterface
{
    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    /**
     * @var Silamoney\Client\Domain\SearchFilters
     * @Type("Silamoney\Client\Domain\SearchFilters")
     */
    private $searchFilters;

    /**
     * Constructor for GetTransactionMsg object.
     *
     * @param string $appHandle
     * @param string $userHandle
     * @param Silamoney\Client\Domain\SearchFilters $searchFilters
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        SearchFilters $searchFilters
    ) {
        $this->searchFilters = $searchFilters;
        $this->header = new Header($appHandle, $userHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && ($this->searchFilters === null || $this->searchFilters->isValid());
    }
}
