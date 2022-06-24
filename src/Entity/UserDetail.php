<?php
/**
 * User detail entity
 */
namespace App\Entity;

use App\Repository\UserDetailRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class UserDetail
 */
#[ORM\Entity(repositoryClass: UserDetailRepository::class)]
#[ORM\Table(name: 'users_details')]
class UserDetail
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
     * Name.
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 64)]
    private ?string $name;

    /**
     * User.
     * @var User
     */
    #[ORM\OneToOne(targetEntity: User::class, fetch: 'EXTRA_LAZY')]
    #[Assert\Type(User::class)]
    private User $user;

    /**
     * Getter for id.
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for name.
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for name.
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Getter for user.
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Setter for user
     * @param User|null $user
     * @return void
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;

    }
}
