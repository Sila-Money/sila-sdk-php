<?php

/**
 * Phone Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use DateTime;
use JMS\Serializer\Annotation\Type;

/**
 * Phone Message
 * Object used as the message in [add|update]/phone endpoint.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class ListDocumentsMessage
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
    private $startDate;
    /**
     * @var string
     * @Type("string")
     */
    private $endDate;
    /**
     * @var array<string>
     * @Type("array<string>")
     */
    private $docTypes;
    /**
     * @var string
     * @Type("string")
     */
    private $search;
    /**
     * @var string
     * @Type("string")
     */
    private $sortBy;

    /**
     * Constructor for Add Phone Message object.
     * @param string $appHandle
     * @param string $userHandle
     * @param DateTime|null $startDate
     * @param DateTime|null $endDate
     * @param array<string>|null $docTypes
     * @param string|null $search
     * @param string|null $sortBy
     * @return Silamoney\Client\Domain\ListDocumentsMessage
     */
    public function __construct(
        string $appHandle,
        string $userHandle,
        DateTime $startDate = null,
        DateTime $endDate = null,
        array $docTypes = null,
        string $search = null,
        string $sortBy = null
    ) {
        $this->header = new Header($appHandle, $userHandle);
        $this->startDate = $startDate ? $startDate->format('Y-m-d') : null;
        $this->endDate = $endDate ? $endDate->format('Y-m-d') : null;
        $this->docTypes = $docTypes;
        $this->search = $search;
        $this->sortBy = $sortBy;
    }
}
