<?php

/**
 * Get Statements Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Get Statements Message
 * Object sent in the Get Statements method.
 * @category Class
 * @package  Silamoney\Client
 * @author   shahid
 */
class GetStatementsMessage implements ValidInterface
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
     * @var string
     * @Type("string")
     */
    private $walletId;

    /**
     * Constructor for GetStatementsMsg object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param string $message
     * @param \Silamoney\Client\Domain\SearchFilters $searchFilters
     * @param string $walletId
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        string $message,
        SearchFilters $searchFilters,
        string $walletId = null
    ) {
        $this->searchFilters = $searchFilters;
        $this->walletId = $walletId;
        $this->message = $message;
        $this->header = new Header($appHandle, $userHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            // && v::stringType()->notEmpty()->validate($this->walletId)
            && ($this->searchFilters === null || $this->searchFilters->isValid());
    }
}
