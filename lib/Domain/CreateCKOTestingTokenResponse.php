<?php

/**
 * Create CKO Testing Token Response
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Create CKO Testing Token Response
 * Object used to map the Create CKO Testing Token Response
 * @category Class
 * @package  Silamoney\Client
 * @author   Manish
 */
class CreateCKOTestingTokenResponse extends BaseResponseWithoutMessage
{
    /**
     * @var string
     * @Type("string")
     */
    public $status;

    /**
     * @var string
     * @Type("string")
     */
    public $reference;

    /**
     * @var string
     * @Type("string")
     */
    public $message;

    /**
     * @var string
     * @Type("string")
     */
    public $token;

    
}
