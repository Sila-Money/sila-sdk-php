<?php

/**
 * Business Entity
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;

/**
 * Business Entity
 * Object used in the business entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class BusinessEntity extends BaseEntity
{
    /**
     * @var string
     */
    private $businessType;

    /**
     * @var string
     */
    private $businessWebsite;

    /**
     * @var string
     */
    private $doingBusinessAs;

    /**
     * @var int
     */
    private $naicsCode;

    /**
     * @var string
     */
    private $registrationState;

    /**
     * @param \Silamoney\Client\Domain\BusinessUser $business
     * @return \Silamoney\Client\Domain\BusinessEnity
     */
    public function __construct(BusinessUser $business)
    {
        parent::__construct($business->getName(), 'business');
        $this->naicsCode = $business->getNaicsCode();
        $this->businessType = $business->getBusinessType();
        $this->businessTypeUuid = $business->getBusinessTypeUuid();
        $this->doingBusinessAs = $business->getDoingBusinessAs();
        $this->businessWebsite = $business->getBusinessWebsite();
        $this->registrationState = $business->getRegistrationState();
    }
}
