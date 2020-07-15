<?php

/**
 * Crypto Entry
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Crypto Entry
 * Object used in the entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class CryptoEntry implements ValidInterface
{
    /**
     * @var string
     * @Type("string")
     */
    private $cryptoAlias;

    /**
     * @var string
     * @Type("string")
     */
    private $cryptoAddress;

    /**
     * @var string
     * @Type("string")
     */
    private $cryptoCode;

    /**
     * Constructor for the CryptoEntry object.
     *
     * @param \Silamoney\Client\Domain\BaseUser $user
     * @return \Silamoney\Client\Domain\CryptoEntry
     */
    public function __construct(BaseUser $user)
    {
        $this->cryptoAddress = $user->getCryptoAddress();
        $this->cryptoAlias = "";
        $this->cryptoCode = CryptoCode::ETH;
    }

    public function isValid(): bool
    {
        $notEmptyString = v::stringType()->notEmpty();
        return v::not(v::nullType())->validate($this->cryptoAlias)
            && $notEmptyString->validate($this->cryptoCode)
            && $notEmptyString->validate($this->cryptoAddress);
    }
}
