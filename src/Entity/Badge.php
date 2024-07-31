<?php

namespace App\Entity;

use App\Repository\BadgeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BadgeRepository::class)]
class Badge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: EPCI::class, inversedBy: 'badges')]
    #[ORM\JoinColumn(nullable: false)]
    private $epci;

    #[ORM\Column(length: 50)]
    #[Groups(['main'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['main'])]
    private ?bool $authorized = null;

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

    public function isAuthorized(): ?bool
    {
        return $this->authorized;
    }

    public function setAuthorized(bool $authorized): static
    {
        $this->authorized = $authorized;

        return $this;
    }

    public function getEpci(): ?EPCI
    {
        return $this->epci;
    }

    public function setEpci(?EPCI $epci): self
    {
        $this->epci = $epci;

        return $this;
    }
}
