<?php

/**
 * Get Institutions Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Get Institutions Message
 * Object sent in the Get Institutions method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class GetInstitutionsMessage implements ValidInterface
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
    private $message;

    /**
     * @var Silamoney\Client\Domain\SearchFilters
     * @Type("Silamoney\Client\Domain\SearchFilters")
     */
     private $searchFilters;

    /**
     * Constructor for GetInstitutionsMessage object.
     * @param string $appHandle
     * @param Silamoney\Client\Domain\SearchFilters|null $searchFilters Optional.
     */
     public function __construct(
        string $appHandle,
        SearchFilters $searchFilters = null
    ) {
        $this->searchFilters = $searchFilters;
        $this->message = Message::HEADER;
        $this->header = new Header($appHandle);
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && ($this->searchFilters === null || $this->searchFilters->isValid());
    }
}
