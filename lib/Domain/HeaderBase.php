<?php

/**
 * Header Base
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Header Base
 * Object used as base of Header and in plaid sameday auth message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class HeaderBase implements ValidInterface
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
     * @var int
     * @Type("int")
     */
    protected $created;

    /**
     * @var string
     * @Type("string")
     */
    protected $userHandle;

    /**
     * @var string
     * @Type("string")
     */
    protected $appHandle;

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
    public function __construct(string $appHandle, string $userHandle = null)
    {
        $this->appHandle = $appHandle;
        $this->userHandle = $userHandle;
        $this->created = time() - 100;
        $this->crypto = CryptoCode::ETH;
        $this->reference = $this->uuid();
        $this->version = Version::ZERO_2;
    }

    public function isValid(): bool
    {
        $notEmptyString = v::stringType()->notEmpty();
        return $notEmptyString->validate($this->appHandle)
            && $notEmptyString->validate($this->userHandle)
            && v::intType()->positive()->validate($this->created);
    }
}
