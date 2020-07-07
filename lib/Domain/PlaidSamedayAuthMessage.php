<?php

/**
 * Plaid Sameday Auth Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Plaid Sameday Auth Message
 * Object sent in plaid sameday auth method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class PlaidSamedayAuthMessage implements ValidInterface
{
    /**
     * @var string
     * @Type("string")
     */
    private $accountName;

    /**
     * @var Silamoney\Client\Domain\HeaderBase
     * @Type("Silamoney\Client\Domain\HeaderBase")
     */
    private $header;

    public function __construct(string $userHandle, string $accountName, string $appHandle)
    {
        $this->header = new HeaderBase($appHandle, $userHandle);
        $this->accountName = $accountName;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->accountName);
    }
}
