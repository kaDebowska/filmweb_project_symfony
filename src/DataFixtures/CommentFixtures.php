<?php
/**
 * Comment fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Movie;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class CommentFixtures.
 */
class CommentFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
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

        $this->createMany(50, 'comments', function (int $i) {
            $comment = new Comment();
            $comment->setContent($this->faker->sentence);
            $comment->setAuthorEmail($this->faker->email);
            $comment->setAuthorNick($this->faker->userName);
            $comment->setCreatedAt(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            /** @var Movie $movie */
            $movie = $this->getRandomReference('movies');
            $comment->setMovie($movie);

            return $comment;
        });

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: MovieFixtures::class}
     */
    public function getDependencies(): array
    {
        return [MovieFixtures::class];
    }
}
