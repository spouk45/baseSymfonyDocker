<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DepotRepository;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;


#[ORM\Entity(repositoryClass: DepotRepository::class)]
class Depot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    #[Groups(['main'])]
    private ?string $accessControlUid = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Badge $badge = null;

    #[ORM\ManyToOne(targetEntity: EPCI::class, inversedBy: 'badges')]
    #[ORM\JoinColumn(nullable: false)]
    private $epci;

    #[ORM\Column]
    #[Groups(['main'])]
    private ?int $timestamp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccessControlUid(): ?string
    {
        return $this->accessControlUid;
    }

    public function setAccessControlUid(string $accessControlUid): static
    {
        $this->accessControlUid = $accessControlUid;

        return $this;
    }

    public function getBadge(): ?Badge
    {
        return $this->badge;
    }

    public function setBadge(?Badge $badge): static
    {
        $this->badge = $badge;

        return $this;
    }

    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $timestamp): static
    {
        $this->timestamp = $timestamp;

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

    #[SerializedName('ref')]
    #[Groups(['main'])]
    public function getBadgeName(): ?string
    {
        return $this->badge ? $this->badge->getName() : null;
    }

    #[SerializedName('dateTime')]
    #[Groups(['main'])]
    public function getIsoDate(): ?\DateTime
    {
        if ($this->timestamp === null) {
            return null;
        }

        return (new \DateTime())->setTimestamp($this->timestamp);
    }
}
