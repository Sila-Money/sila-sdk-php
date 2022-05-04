<?php

/**
 * Link Card Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

/**
 * Link Card Response
 * Object used to map Link Card response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid Ahmed Sheikh <shahid.sheikh@silamoney.com>
 */
class LinkCardResponse extends BaseResponse
{
    /**
     * accountName
     * @var string
     * @Type("string")
     */
    public $accountName;

    /**
     * avs
     * @var string
     * @Type("string")
     */
    public $avs;

    public function getAccountName(): string
    {
        return $this->accountName;
    }

    public function getAvs(): string
    {
        return $this->avs;
    }
}
