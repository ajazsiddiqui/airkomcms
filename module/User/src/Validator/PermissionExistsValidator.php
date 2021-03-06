<?php

namespace User\Validator;

use Laminas\Validator\AbstractValidator;
use User\Entity\Permission;

/**
 * This validator class is designed for checking if there is an existing permission
 * with such a name.
 */
class PermissionExistsValidator extends AbstractValidator
{
    // Validation failure message IDs.
    public const NOT_SCALAR = 'notScalar';
    public const PERMISSION_EXISTS = 'permissionExists';
    /**
     * Available validator options.
     *
     * @var array
     */
    protected $options = [
        'entityManager' => null,
        'permission' => null,
    ];

    /**
     * Validation failure messages.
     *
     * @var array
     */
    protected $messageTemplates = [
        self::NOT_SCALAR => 'The email must be a scalar value',
        self::PERMISSION_EXISTS => 'Another permission with such name already exists',
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
            if (isset($options['permission'])) {
                $this->options['permission'] = $options['permission'];
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

            return false;
        }

        // Get Doctrine entity manager.
        $entityManager = $this->options['entityManager'];

        $permission = $entityManager->getRepository(Permission::class)
            ->findOneByName($value)
        ;

        if (null == $this->options['permission']) {
            $isValid = (null == $permission);
        } else {
            if ($this->options['permission']->getName() != $value && null != $permission) {
                $isValid = false;
            } else {
                $isValid = true;
            }
        }

        // If there were an error, set error message.
        if (!$isValid) {
            $this->error(self::PERMISSION_EXISTS);
        }

        // Return validation result.
        return $isValid;
    }
}
