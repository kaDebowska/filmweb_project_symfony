<?php
/**
 * Task fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Movie;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class MovieFixtures.
 */
class MovieFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
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

        $this->createMany(100, 'movies', function (int $i) {
            $movie = new Movie();
            $movie->setTitle($this->faker->sentence);
            $movie->setCreatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $movie->setUpdatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $movie->setYear($this->faker->numberBetween(1900, 2022));
            $movie->setDescription($this->faker->realText);
            $movie->setDirector($this->faker->name);
            $movie->setDuration($this->faker->numberBetween(60, 180));

            /** @var Category $categories */
            $categories = $this->getRandomReferences('categories', $this->faker->numberBetween(1, 3));
            foreach ($categories as $category) {
                $movie->addCategory($category);
            }

            return $movie;
        });
        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: CategoryFixtures::class}
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
