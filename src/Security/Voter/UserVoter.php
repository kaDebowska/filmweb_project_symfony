<?php
/**
 * User voter.
 */

namespace App\Security\Voter;

use App\Entity\Enum\UserRole;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * class UserVoter.
 */
class UserVoter extends Voter
{
    /**
     * Edit permission.
     *
     * @const string
     */
    public const EDIT = 'EDIT';

    /**
     * View permission.
     *
     * @const string
     */
    public const VIEW = 'VIEW';

    /**
     * Delete permission.
     *
     * @const string
     */
    public const DELETE = 'DELETE';

    /**
     * Security helper.
     */
    private Security $security;

    /**
     * OrderVoter constructor.
     *
     * @param Security $security Security helper
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed  $subject   The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool Result
     */
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof User;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string         $attribute Permission name
     * @param mixed          $subject   Object
     * @param TokenInterface $token     Security token
     *
     * @return bool Vote result
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::VIEW:
                return $this->canView($subject, $user);
            case self::DELETE:
                return $this->canDelete($subject, $user);
        }

        return false;
    }

    /**
     * Check if user can edit user.
     *
     * @param User          $user    User entity
     * @param UserInterface $manager
     *
     * @return bool Result
     */
    private function canEdit(User $user, UserInterface $manager): bool
    {
        return $user === $manager || $this->security->isGranted(UserRole::ROLE_ADMIN->value);
    }

    /**
     * Check if user can view user.
     *
     * @param User          $user    User entity
     * @param UserInterface $manager
     *
     * @return bool Result
     */
    private function canView(User $user, UserInterface $manager): bool
    {
        return $user === $manager || $this->security->isGranted(UserRole::ROLE_ADMIN->value);
    }

    /**
     * Check if user can delete user.
     *
     * @param User          $user    User entity
     * @param UserInterface $manager
     *
     * @return bool Result
     */
    private function canDelete(User $user, UserInterface $manager): bool
    {
        return $user === $manager || $this->security->isGranted(UserRole::ROLE_ADMIN->value);
    }
}
