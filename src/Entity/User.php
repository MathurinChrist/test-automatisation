<?php

namespace App\Entity;

use App\helpers\Helpers;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $name = null; // lastname

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $password = null;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $birthDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function isValid(): bool
    {
        if (
            empty($this->email) ||
            empty($this->name) ||
            empty($this->firstName) ||
            empty($this->password) ||
            $this->birthDate === null
        ) {
            return false;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if (!$this->hasValidPassword()) {
            return false;
        }

        if (!$this->hasValidAge()) {
            return false;
        }

        return true;
    }

    private function hasValidPassword(): bool
    {
        return preg_match(
            '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,40}$/',
            $this->password
        ) === 1;
    }

    private function hasValidAge(): bool
    {
        $today = new \DateTimeImmutable();
        $age = $today->diff($this->birthDate)->y;

        return $age >= 13;
    }
}
