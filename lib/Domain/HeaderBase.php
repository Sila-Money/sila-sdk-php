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
    }

    public function isValid(): bool
    {
        $notEmptyString = v::stringType()->notEmpty();
        return $notEmptyString->validate($this->appHandle)
            && $notEmptyString->validate($this->userHandle)
            && v::intType()->positive()->validate($this->created);
    }
}
