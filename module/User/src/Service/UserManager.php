<?php

namespace User\Service;

use Laminas\Crypt\Password\Bcrypt;
use Laminas\Math\Rand;
use SendGrid;
use Settings\Entity\Settings;
use User\Entity\Role;
use User\Entity\User;

/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class UserManager
{
    /**
     * Doctrine entity manager.
     *
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Role manager.
     *
     * @var User\Service\RoleManager
     */
    private $roleManager;

    /**
     * Permission manager.
     *
     * @var User\Service\PermissionManager
     */
    private $permissionManager;

    /**
     * Constructs the service.
     *
     * @param mixed $entityManager
     * @param mixed $roleManager
     * @param mixed $permissionManager
     */
    public function __construct($entityManager, $roleManager, $permissionManager)
    {
        $this->entityManager = $entityManager;
        $this->roleManager = $roleManager;
        $this->permissionManager = $permissionManager;
    }

    /**
     * This method adds a new user.
     *
     * @param mixed $data
     * @param mixed $newFileName
     */
    public function addUser($data, $newFileName)
    {
        // Do not allow several users with the same email address.
        if ($this->checkUserExists($data['email'])) {
            throw new \Exception('User with email address '.$data['$email'].' already exists');
        }

        // Create new User entity.
        $user = new User();
        $user->setEmail($data['email']);
        $user->setAlternateEmail($data['alternate_email']);
        $user->setFullName($data['full_name']);
        $user->setContactNo($data['contact_no']);
        $user->setBranch($data['branch']);
        $user->setDesignation($data['designation']);
        $user->setUserType($data['user_type']);
        $user->setProfilePic($newFileName);

        // Encrypt password and store the password in encrypted state.
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($data['password']);
        $user->setPassword($passwordHash);

        $user->setStatus($data['status']);

        $currentDate = date('Y-m-d H:i:s');
        $user->setDateCreated($currentDate);

        // Assign roles to user.
        $this->assignRoles($user, $data['roles']);

        // Add the entity to the entity manager.
        $this->entityManager->persist($user);

        // Apply changes to database.
        $this->entityManager->flush();

        return $user;
    }

    /**
     * This method updates data of an existing user.
     *
     * @param mixed $user
     * @param mixed $data
     * @param mixed $newFileName
     */
    public function updateUser($user, $data, $newFileName)
    {
        // Do not allow to change user email if another user with such email already exits.
        if ($user->getEmail() != $data['email'] && $this->checkUserExists($data['email'])) {
            throw new \Exception('Another user with email address '.$data['email'].' already exists');
        }

        $user->setEmail($data['email']);
		$user->setAlternateEmail($data['alternate_email']);
        $user->setFullName($data['full_name']);
        $user->setContactNo($data['contact_no']);
        $user->setBranch($data['branch']);
        $user->setDesignation($data['designation']);
        $user->setUserType($data['user_type']);
        $user->setProfilePic($newFileName);
        $user->setStatus($data['status']);

        // Assign roles to user.
        $this->assignRoles($user, $data['roles']);

        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }

    /**
     * This method checks if at least one user presents, and if not, creates
     * 'Admin' user with email 'admin@example.com' and password 'Secur1ty'.
     */
    public function createAdminUserIfNotExists()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy([]);
        if (null == $user) {
            $this->permissionManager->createDefaultPermissionsIfNotExist();
            $this->roleManager->createDefaultRolesIfNotExist();

            $user = new User();
            $user->setEmail('admin@onlinevacations.in');
            $user->setFullName('Admin');
            $bcrypt = new Bcrypt();
            $passwordHash = $bcrypt->create('Secur1ty');
            $user->setPassword($passwordHash);
            $user->setStatus(User::STATUS_ACTIVE);
            $user->setDateCreated(date('Y-m-d H:i:s'));

            // Assign user Administrator role
            $adminRole = $this->entityManager->getRepository(Role::class)
                ->findOneByName('Administrator')
            ;
            if (null == $adminRole) {
                throw new \Exception('Administrator role doesn\'t exist');
            }

            $user->getRoles()->add($adminRole);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }

    /**
     * Checks whether an active user with given email address already exists in the database.
     *
     * @param mixed $email
     */
    public function checkUserExists($email)
    {
        $user = $this->entityManager->getRepository(User::class)
            ->findOneByEmail($email);

        return null !== $user;
    }

    /**
     * Checks that the given password is correct.
     *
     * @param mixed $user
     * @param mixed $password
     */
    public function validatePassword($user, $password)
    {
        $bcrypt = new Bcrypt();
        $passwordHash = $user->getPassword();

        if ($bcrypt->verify($password, $passwordHash)) {
            return true;
        }

        return false;
    }

    /**
     * Generates a password reset token for the user. This token is then stored in database and
     * sent to the user's E-mail address. When the user clicks the link in E-mail message, he is
     * directed to the Set Password page.
     *
     * @param mixed $user
     */
    public function generatePasswordResetToken($user)
    {
        // Generate a token.
        $token = Rand::getString(32, '0123456789abcdefghijklmnopqrstuvwxyz', true);
        $user->setPasswordResetToken($token);

        $currentDate = date('Y-m-d H:i:s');
        $user->setPasswordResetTokenCreationDate($currentDate);

        $this->entityManager->flush();

        $subject = 'Password Reset Link';

        $httpHost = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
        $passwordResetUrl = 'http://'.$httpHost.'/users/set-password?token='.$token;

        $body = 'Please follow the link below to reset your password:\n ';
        $body .= "{$passwordResetUrl}\n";
        $body .= "If you haven't asked to reset your password, please ignore this message.\n";

        // Send email to user.
        //mail($user->getEmail(), $subject, $body);

        //SEND NOTIFICATIONS
        $settings = $this->entityManager->getRepository(Settings::class)
            ->findOneBy(['id' => 1])
        ;

        $from = new SendGrid\Email($settings->getNameEmailer(), 'members@onlinevacations.in');
        $subject = 'Password Reset Link';
        $to = new SendGrid\Email(null, $user->getEmail());

        $content = new SendGrid\Content('text/html', $body);
        $mail = new SendGrid\Mail($from, $subject, $to, $content);
        $sg = new \SendGrid($settings->getSendgridApi());
        $response = $sg->client->mail()->send()->post($mail);
    }

    /**
     * Checks whether the given password reset token is a valid one.
     *
     * @param mixed $passwordResetToken
     */
    public function validatePasswordResetToken($passwordResetToken)
    {
        $user = $this->entityManager->getRepository(User::class)
            ->findOneByPasswordResetToken($passwordResetToken);

        if (null == $user) {
            return false;
        }

        $tokenCreationDate = $user->getPasswordResetTokenCreationDate();
        $tokenCreationDate = strtotime($tokenCreationDate);

        $currentDate = strtotime('now');

        if ($currentDate - $tokenCreationDate > 24 * 60 * 60) {
            return false; // expired
        }

        return true;
    }

    /**
     * This method sets new password by password reset token.
     *
     * @param mixed $passwordResetToken
     * @param mixed $newPassword
     */
    public function setNewPasswordByToken($passwordResetToken, $newPassword)
    {
        if (!$this->validatePasswordResetToken($passwordResetToken)) {
            return false;
        }

        $user = $this->entityManager->getRepository(User::class)
            ->findOneByPasswordResetToken($passwordResetToken);

        if (null === $user) {
            return false;
        }

        // Set new password for user
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($newPassword);
        $user->setPassword($passwordHash);

        // Remove password reset token
        $user->setPasswordResetToken(null);
        $user->setPasswordResetTokenCreationDate(null);

        $this->entityManager->flush();

        return true;
    }

    /**
     * This method is used to change the password for the given user. To change the password,
     * one must know the old password.
     *
     * @param mixed $user
     * @param mixed $data
     */
    public function changePassword($user, $data)
    {
        //$oldPassword = $data['old_password'];

        // Check that old password is correct
        //if (!$this->validatePassword($user, $oldPassword)) {
        //return false;
        //}

        $newPassword = $data['new_password'];

        // Check password length
        if (strlen($newPassword) < 6 || strlen($newPassword) > 64) {
            return false;
        }

        // Set new password for user
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($newPassword);
        $user->setPassword($passwordHash);

        // Apply changes
        $this->entityManager->flush();

        return true;
    }

    /**
     * A helper method which assigns new roles to the user.
     *
     * @param mixed $user
     * @param mixed $roleIds
     */
    private function assignRoles($user, $roleIds)
    {
        // Remove old user role(s).
        $user->getRoles()->clear();

        // Assign new role(s).
        foreach ($roleIds as $roleId) {
            $role = $this->entityManager->getRepository(Role::class)
                ->find($roleId)
            ;
            if (null == $role) {
                throw new \Exception('Not found role by ID');
            }

            $user->addRole($role);
        }
    }
}
