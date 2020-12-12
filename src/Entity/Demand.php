<?php

namespace App\Entity;

use App\Repository\DemandRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandRepository::class)
 */
class Demand
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="demands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $acceptation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateMaskRecovery;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAcceptation(): ?bool
    {
        return $this->acceptation;
    }

    public function setAcceptation(bool $acceptation): self
    {
        $this->acceptation = $acceptation;

        return $this;
    }

    public function getDateMaskRecovery(): ?\DateTimeInterface
    {
        return $this->dateMaskRecovery;
    }

    public function setDateMaskRecovery(?\DateTimeInterface $dateMaskRecovery): self
    {
        $this->dateMaskRecovery = $dateMaskRecovery;

        return $this;
    }
}
