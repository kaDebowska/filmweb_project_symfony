<?php
/**
 * User detail service interface.
 */

namespace App\Service;

use App\Entity\User;
use App\Entity\UserDetail;

/**
 * Interface UserDetailServiceInterface.
 */
interface UserDetailServiceInterface
{
    /**
     * Save entity.
     *
     * @param UserDetail $userDetail UserDetail entity
     */
    public function save(UserDetail $userDetail): void;

    /**
     * Find one entity.
     * @param User $user
     * @return UserDetail|null
     */
    public function findOneByUserId(User $user): ?UserDetail;
}
