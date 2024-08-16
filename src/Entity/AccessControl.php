<?php

namespace App\Entity;

use App\Repository\AccessControlRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessControlRepository::class)]
class AccessControl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $uid = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?EPCI $epci = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getEpci(): ?EPCI
    {
        return $this->epci;
    }

    public function setEpci(?EPCI $epci): static
    {
        $this->epci = $epci;

        return $this;
    }
}
