<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment.
 *
 * @psalm-suppress MissingConstructor
 */
#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\Table(name: 'comments')]
class Comment
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
     * Comment.
     *
     * @var string|null
     */
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 2000)]
    #[ORM\Column(type: 'text')]
    private ?string $content = null;

    /**
     * Author email.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $authorEmail;

    /**
     * Author nick.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank]
    private ?string $authorNick = null;

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
     * Movie.
     *
     * @var Movie
     */
    #[ORM\ManyToOne(targetEntity: Movie::class, fetch: 'EXTRA_LAZY')]
    #[Assert\Type(Movie::class)]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(nullable: false)]
    private Movie $movie;


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
     * Getter for Content.
     *
     * @return string|null Content
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Setter for Content.
     * @param string $content
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Getter for author email.
     *
     * @return string|null
     */
    public function getAuthorEmail(): ?string
    {
        return $this->authorEmail;
    }

    /**
     * Setter for author email.
     * @param string $authorEmail
     * @return void
     */
    public function setAuthorEmail(string $authorEmail): void
    {
        $this->authorEmail = $authorEmail;
    }

    /**
     * Getter for created at.
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Setter for created at.
     * @param DateTimeImmutable $createdAt
     * @return void
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Getter for movie.
     * @return Movie|null
     */
    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    /**
     * Setter for movie.
     * @param Movie|null $movie
     * @return void
     */
    public function setMovie(?Movie $movie): void
    {
        $this->movie = $movie;
    }

    /**
     * Getter for author nick.
     * @return string|null
     */
    public function getAuthorNick(): ?string
    {
        return $this->authorNick;
    }

    /**
     * Setter for author nick
     * @param string|null $authorNick
     * @return void
     */
    public function setAuthorNick(?string $authorNick): void
    {
        $this->authorNick = $authorNick;
    }
}
