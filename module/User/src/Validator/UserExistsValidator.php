<?php

namespace User\Validator;

use Laminas\Validator\AbstractValidator;
use User\Entity\User;

/**
 * This validator class is designed for checking if there is an existing user
 * with such an email.
 */
class UserExistsValidator extends AbstractValidator
{
    // Validation failure message IDs.
    public const NOT_SCALAR = 'notScalar';
    public const USER_EXISTS = 'userExists';
    /**
     * Available validator options.
     *
     * @var array
     */
    protected $options = [
        'entityManager' => null,
        'user' => null,
    ];

    /**
     * Validation failure messages.
     *
     * @var array
     */
    protected $messageTemplates = [
        self::NOT_SCALAR => 'The email must be a scalar value',
        self::USER_EXISTS => 'Another user with such an email already exists',
    ];

    /**
     * Constructor.
     *
     * @param null|mixed $options
     */
    public function __construct($options = null)
    {
        // Set filter options (if provided).
        if (is_array($options)) {
            if (isset($options['entityManager'])) {
                $this->options['entityManager'] = $options['entityManager'];
            }
            if (isset($options['user'])) {
                $this->options['user'] = $options['user'];
            }
        }

        // Call the parent class constructor
        parent::__construct($options);
    }

    /**
     * Check if user exists.
     *
     * @param mixed $value
     */
    public function isValid($value)
    {
        if (!is_scalar($value)) {
            $this->error(self::NOT_SCALAR);

            return $false;
        }

        // Get Doctrine entity manager.
        $entityManager = $this->options['entityManager'];

        $user = $entityManager->getRepository(User::class)
            ->findOneByEmail($value)
        ;

        if (null == $this->options['user']) {
            $isValid = (null == $user);
        } else {
            if ($this->options['user']->getEmail() != $value && null != $user) {
                $isValid = false;
            } else {
                $isValid = true;
            }
        }

        // If there were an error, set error message.
        if (!$isValid) {
            $this->error(self::USER_EXISTS);
        }

        // Return validation result.
        return $isValid;
    }
}
