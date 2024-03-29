<?php

/**
 * Get Transactions Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Get Transactions Message
 * Object sent in the Get Transactions method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class GetTransactionsMessage implements ValidInterface
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
     * @var string
     * @Type("string")
     */
    private $message;

    /**
     * Constructor for GetTransactionMsg object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param Silamoney\Client\Domain\SearchFilters $searchFilters
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        SearchFilters $searchFilters
    ) {
        $this->searchFilters = $searchFilters;
        $this->message = Message::GET_TRANSACTIONS;
        $this->header = new Header($appHandle, $userHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && ($this->searchFilters === null || $this->searchFilters->isValid());
    }
}
