<?php

/**
 * Mock Wire Out File Reponse
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Pagination;

/**
 * Mock Wire Out File Reponse
 * Object used to map the mockWireOutFile method response.
 * @category Class
 * @package  Silamoney\Client
 * @author   Shahid Ahmed <shahid.sheikh@silamoney.com>
 */
class MockWireOutFileResponse extends BaseResponse
{
    /**
     * Message
     * @var string
     * @Type("string")
     */
    public $transactionId;

    /**
     * Message
     * @var string
     * @Type("string")
     */
    public $wireStatus;
    
}
