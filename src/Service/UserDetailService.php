<?php
/**
 * User detail service.
 */

namespace App\Service;

use App\Entity\User;
use App\Entity\UserDetail;
use App\Repository\UserDetailRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class UserDetailService.
 */
class UserDetailService implements UserDetailServiceInterface
{
    /**
     * Task repository.
     */
    private UserDetailRepository $userDetailRepository;

    /**
     * Constructor.
     *
     * @param UserDetailRepository   $userDetailRepository  User detail repository
     */
    public function __construct(UserDetailRepository $userDetailRepository)
    {
        $this->userDetailRepository = $userDetailRepository;
    }

    /**
     * Save entity.
     *
     * @param UserDetail $userDetail User detail entity
     */
    public function save(UserDetail $userDetail): void
    {
        $this->userDetailRepository->save($userDetail);
    }

    /**
     * Find one by user id.
     *
     * @param User $user User entity
     *
     * @return UserDetail|null UserDetail entity
     *
     */
    public function findOneByUserId(User $user): ?UserDetail
    {
        $userId = $user->getId();
        return $this->userDetailRepository->findOneBy(['user' => $userId]);
    }
}
