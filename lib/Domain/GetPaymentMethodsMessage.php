<?php

/**
 * Get Payment Methods Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Get PaymentMethods Message
 * Object sent in the get PaymentMethods method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Walter Zelada <wzelada@digitalgeko.com>
 */
class GetPaymentMethodsMessage implements ValidInterface
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
     ** Constructor for GetPaymentMethodsMessage object.
     *
     * @param string $userHandle
     * @param string $appHandle
     * @param Silamoney\Client\Domain\SearchFilters $searchFilters
     * @return \Silamoney\Client\Domain\GetPaymentMethodsMessage
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        SearchFilters $searchFilters = null
    ) {
        $this->searchFilters = $searchFilters;
        $this->header = new Header($appHandle, $userHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && ($this->searchFilters === null || $this->searchFilters->isValid());
    }
}
