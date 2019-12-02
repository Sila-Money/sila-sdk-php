<?php

/**
 * Entity
 * PHP version 7.2
 */

namespace Silamoney\Client\Domain;

use JMS\Serializer\Annotation\Type;
use Respect\Validation\Validator as v;

/**
 * Entity
 * Object used in the entity message.
 * @category Class
 * @package  Silamoney\Client
 * @author   José Morales <jmorales@digitalgeko.com>
 */
class Entity implements ValidInterface
{
    /**
     * @var string
     * @Type("string")
     */
    private $birthdate;

    /**
     * @var string
     * @Type("string")
     */
    private $entityName;

    /**
     * @var string
     * @Type("string")
     */
    private $lastName;

    /**
     * @var string
     * @Type("string")
     */
    private $relationship;

    /**
     * @var string
     * @Type("string")
     */
    private $firstName;

    /**
     * Constructor for Entity object.
     *
     * @param Silamoney\Client\Domian\User $user
     */
    public function __construct(User $user)
    {
        $pattern = 'yyyy-MM-dd';
        $date = $user->getBirthdate()->format($pattern);
        $this->birthdate = $date;
        $this->firstName = $user->getFirstName();
        $this->lastName = $user->getLastName();
        $this->entityName = $this->firstName + " " + $this->lastName;
        $this->relationship = Relationship::USER;
    }

    public function isValid(): bool
    {
        $notEmptyString = v::stringType()->notEmpty();
        return v::date()->validate($this->birthdate)
            && $notEmptyString->validate($this->entityName)
            && $notEmptyString->validate($this->firstName)
            && $notEmptyString->validate($this->lastName)
            && $notEmptyString->validate($this->relationship);
    }
}
