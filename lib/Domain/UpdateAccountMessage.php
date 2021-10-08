<?php

/**
 * Update Account Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Update Account Message
 * Object sent in the update account method.
 * @category Class
 * @package  Silamoney\Client
 * @author   Alanfer Orozco <aorozco@digitalgeko.com>
 */
class UpdateAccountMessage implements ValidInterface
{
    /**
     * @var string
     * @Type("string")
     */
    private $accountName;

    /**
     * @var string
     * @Type("string")
     */
     private $newAccountName;
    
     /**
     * @var isActive
     * @Type("bool")
     */
    private $isActve;

    /**
     * @var Silamoney\Client\Domain\Header
     * @Type("Silamoney\Client\Domain\Header")
     */
    private $header;

    /**
     * @var string
     * @Type("string")
     */
    private $message;

    /**
     * Constructor for UpdateAccountMessage object.
     *
     * @param string $userHandle
     * @param string $accountName
     * @param string $newAccountName
     * @param string $appHandle
     */
    public function __construct(
        string $userHandle,
        string $appHandle,
        string $accountName,
        string $newAccountName,
        bool $isActve=true
    ) {
        $this->accountName = $accountName;
        $this->newAccountName = $newAccountName;
        $this->isActve = $isActve;
        $this->header = new Header($appHandle, $userHandle);
        $this->message = Message::HEADER;
    }

    public function isValid(): bool
    {
        return v::notOptional()->validate($this->header)
            && $this->header->isValid()
            && v::stringType()->notEmpty()->validate($this->message)
            && ($this->accountName === null || v::stringType()->validate($this->accountName))
            && ($this->newAccountName === null || v::stringType()->validate($this->newAccountName));
    }
}
