<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SequencerRepository")
 */
class Sequencer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sequence;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $agency;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createtime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSequence(): ?string
    {
        return $this->sequence;
    }

    public function setSequence(string $sequence): self
    {
        $this->sequence = $sequence;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getAgency(): ?string
    {
        return $this->agency;
    }

    public function setAgency(string $agency): self
    {
        $this->agency = $agency;

        return $this;
    }

    public function getCreatetime(): ?\DateTimeInterface
    {
        return $this->createtime;
    }

    public function setCreatetime(\DateTimeInterface $createtime): self
    {
        $this->createtime = $createtime;

        return $this;
    }
}
