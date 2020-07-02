<?php

/**
 * Header
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Header
 * Object used in the multiple msg.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Header extends HeaderBase
{
    /**
     * @var string
     * @Type("string")
     */
    private $reference;

    /**
     * @var string
     * @Type("string")
     */
    private $version;

    /**
     * @var string
     * @Type("string")
     */
    private $crypto;

    /**
     * Generate a UUID to use for the reference.
     *
     * @return string
     * @throws \Exception
     */
    private function uuid()
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Constructor for header object.
     *
     * @param string $userHandle
     * @param string $appHandle
     */
    public function __construct(string $userHandle, string $appHandle)
    {
        parent::__construct($appHandle, $userHandle);
        $this->crypto = CryptoCode::ETH;
        $this->reference = $this->uuid();
        $this->version = Version::ZERO_2;
    }

    public function isValid(): bool
    {
        $notEmptyString = v::stringType()->notEmpty();
        return $notEmptyString->validate($this->authHandle)
            && $notEmptyString->validate($this->userHandle)
            && v::intType()->positive()->validate($this->created)
            && $notEmptyString->validate($this->crypto)
            && $notEmptyString->validate($this->reference)
            && $notEmptyString->validate($this->version);
    }
}
