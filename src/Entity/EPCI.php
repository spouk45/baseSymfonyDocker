<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class EPCI implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $token = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    // Implémentation des méthodes de UserInterface
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }


    public function eraseCredentials(): void
    {
        // effacer des données sensibles si nécessaire
    }

    public function getUserIdentifier(): string
    {
        return $this->name; // ou tout autre identifiant unique
    }

    public function __toString(): string
    {
        return $this->name;
    }

}
