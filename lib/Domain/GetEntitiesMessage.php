<?php

/**
 * Get Entities Message
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Get Entities Message
 * Object sent in the getEntities method.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class GetEntitiesMessage
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
    private $message;

    /**
     * @var string
     * @Type("string")
     */
    private $entityType;

    /**
     * Constructor for GetAccountsMsg object.
     *
     * @param string $userHandle
     * @param string $appHandle
     */
    public function __construct(string $appHandle, string $entityType = null)
    {
        $this->header = new Header($appHandle);
        $this->message = Message::HEADER;
        if(!$this->isEmptyOrHasOnlyWhiteSpaces($entityType)){
            $this->entityType = $entityType;
        }
    }

    /**
     * Validate if an attribute can be sent to the API.
     * @return bool
     */
     private function isEmptyOrHasOnlyWhiteSpaces(string $attribute = null){
        return empty($attribute) || ctype_space($attribute);
    }
}
