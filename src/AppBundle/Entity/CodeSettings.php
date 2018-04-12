<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class CodeSettings
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="integer",
     *     message="The value is not a valid type."
     * )
     */
    public $numberOfCodes;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="integer",
     *     message="The value is not a valid type."
     * )
     */
    public $length;
}