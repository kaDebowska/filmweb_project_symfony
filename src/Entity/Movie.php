<?php
/**
 * Movie entity.
 */

namespace App\Entity;

use App\Repository\MovieRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


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
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $title;

    /**
     * Year.
     *
     * @var integer|null
     */
    #[ORM\Column(type: 'integer')]
    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\LessThan(2022)]
    #[Assert\GreaterThan(1900)]
    private ?int $year = null;

    /**
     * Director.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 45)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 45)]
    private ?string $director = null;

    /**
     * Duration.
     *
     * @var int|null
     */
    #[ORM\Column(type: 'integer')]
    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\GreaterThan(50)]
    #[Assert\LessThan(180)]
    private ?int $duration = null;

    /**
     * Description.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'text')]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 45, max: 2000)]
    private ?string $description = null;

    /**
     * Created at.
     *
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\Type(DateTimeImmutable::class)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?DateTimeImmutable $createdAt;

    /**
     * Updated at.
     *
     * @var DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\Type(DateTimeImmutable::class)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?DateTimeImmutable $updatedAt;

    /**
     * Categories.
     *
     * @var ArrayCollection<int, Category>
     */
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: Category::class, fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    #[ORM\JoinTable(name: 'movies_categories')]
    private $category;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }
}
