<?php
/**
 * Movie entity.
 */

namespace App\Entity;

use App\Repository\MovieRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Movie.
 *
 * @psalm-suppress MissingConstructor
 */
#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ORM\Table(name: 'movies')]
class Movie
{
    /**
     * Primary key.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Title.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 64)]
    private ?string $title = null;

    /**
     * Year.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 4)]
    private ?string $year = null;

    /**
     * Director.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 45)]
    private ?string $director = null;

    /**
     * Duration.
     *
     * @var int|null
     */
    #[ORM\Column(type: 'integer')]
    private ?int $duration = null;

    /**
     * Description.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    /**
     * Created at.
     *
     * @var DateTimeImmutable|null
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeImmutable|null
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $updatedAt;

    /**
     * Getter for Id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Title.
     *
     * @return string|null Id
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for title.
     *
     * @param string|null $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter for Year.
     *
     * @return string|null Id
     */
    public function getYear(): ?string
    {
        return $this->year;
    }

    /**
     * Setter for Year.
     *
     * @param string|null $year Year
     */
    public function setYear(string $year): void
    {
        $this->year = $year;
    }

    /**
     * Getter for director.
     *
     * @return string|null Director
     */
    public function getDirector(): ?string
    {
        return $this->director;
    }

    /**
     * Setter for director.
     *
     * @param string|null $director Director
     */
    public function setDirector(string $director): void
    {
        $this->director = $director;
    }

    /**
     * Getter for duration.
     *
     * @return int|null Title
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * Setter for duration.
     *
     * @param int|null $duration Duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * Getter for description.
     *
     * @return string|null Title
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter for description.
     *
     * @param string|null $description DEscription
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Getter for created at.
     *
     * @return DateTimeImmutable|null Created at
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Setter for created at.
     *
     * @param DateTimeImmutable|null $createdAt Created at
     */
    public function setCreatedAt(?DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for updated at.
     *
     * @return DateTimeImmutable|null Updated at
     */
    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Setter for updated at.
     *
     * @param DateTimeImmutable|null $updatedAt Updated at
     */
    public function setUpdatedAt(?DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
