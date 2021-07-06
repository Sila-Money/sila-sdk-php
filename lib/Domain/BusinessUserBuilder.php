<?php

/**
 * Business User Builder
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

class BusinessUserBuilder extends BaseUserBuilder
{
    private $entityName;
    private $naicsCode;
    private $businessType;
    private $businessTypeUuid;
    private $doingBusinessAs;
    private $businessWebsite;

    public function entityName(string $entityName): BusinessUserBuilder
    {
        $this->entityName = $entityName;
        return $this;
    }

    public function naicsCode(int $naicsCode): BusinessUserBuilder
    {
        $this->naicsCode = $naicsCode;
        return $this;
    }

    public function businessType(string $businessType): BusinessUserBuilder
    {
        $this->businessType = $businessType;
        return $this;
    }

    public function businessTypeUuid(string $businessTypeUuid): BusinessUserBuilder
    {
        $this->businessTypeUuid = $businessTypeUuid;
        return $this;
    }

    public function doingBusinessAs(string $doingBusinessAs): BusinessUserBuilder
    {
        if(!$this->isEmptyOrHasOnlyWhiteSpaces($doingBusinessAs)){
            $this->doingBusinessAs = $doingBusinessAs;
        }
        return $this;
    }

    public function businessWebsite(string $businessWebsite): BusinessUserBuilder
    {
        if(!$this->isEmptyOrHasOnlyWhiteSpaces($businessWebsite)){
            $this->businessWebsite = $businessWebsite;
        }
        return $this;
    }

    public function build(): BusinessUser
    {
        return new BusinessUser(
            $this->handle,
            $this->entityName,
            $this->address,
            $this->address2,
            $this->city,
            $this->state,
            $this->zipCode,
            $this->phone,
            $this->email,
            $this->identityNumber,
            $this->cryptoAddress,
            $this->naicsCode,
            $this->businessType,
            $this->businessTypeUuid,
            $this->doingBusinessAs,
            $this->businessWebsite
        );
    }

    /**
     * Validate if an attribute can be sent to the API.
     * @return bool
     */
     private function isEmptyOrHasOnlyWhiteSpaces(string $attribute = null){
        return empty($attribute) || ctype_space($attribute);
    }
}
