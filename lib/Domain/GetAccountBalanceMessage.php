<?php

/**
 * Get Accounts Balance Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Get Accounts Balance Message
 * Object sent in the Get Accounts method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Carlos Sosa <csosa@digitalgeko.com>
 */
class GetAccountBalanceMessage implements ValidInterface
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
    private $accountName;

    /**
     * Constructor for GetAccountsMsg object.
     *
     * @param string $userHandle
     * @param string $appHandle
     */
    public function __construct(string $userHandle, string $appHandle, string $accountName)
    {
        $this->header = new Header($appHandle, $userHandle);
        $this->accountName = $accountName;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->accountName);
    }
}
