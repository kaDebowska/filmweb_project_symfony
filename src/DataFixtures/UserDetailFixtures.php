<?php
/**
 * User detail fixtures.
 */

namespace App\DataFixtures;

use App\Entity\UserDetail;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class UserDetailFixtures.
 */
class UserDetailFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(10, 'users_details', function (int $i) {
            $userDetail = new UserDetail();
            $userDetail->setName($this->faker->userName);

            /** @var User $user */
            $user = $this->getReference('users'.'_'.$i);
            $userDetail->setUser($user);

            return $userDetail;
        });
        $this->createMany(3, 'admins_details', function (int $i) {
            $userDetail = new UserDetail();
            $userDetail->setName($this->faker->userName);

            /** @var User $admin */
            $admin = $this->getReference('admins'.'_'.$i);
            $userDetail->setUser($admin);

            return $userDetail;
        });
        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: UserFixtures::class}
     */
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
