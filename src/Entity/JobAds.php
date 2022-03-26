<?php

namespace App\Entity;

use App\Repository\JobAdsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobAdsRepository::class)]
class JobAds
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $address;

    #[ORM\Column(type: 'string', length: 5)]
    private $zipcode;

    #[ORM\Column(type: 'boolean')]
    private $is_validated;

    #[ORM\ManyToOne(targetEntity: Recruiters::class, inversedBy: 'JobAds')]
    #[ORM\JoinColumn(nullable: false)]
    private $recruiters;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getIsValidated(): ?bool
    {
        return $this->is_validated;
    }

    public function setIsValidated(bool $is_validated): self
    {
        $this->is_validated = $is_validated;

        return $this;
    }

    public function getRecruiters(): ?Recruiters
    {
        return $this->recruiters;
    }

    public function setRecruiters(?Recruiters $recruiters): self
    {
        $this->recruiters = $recruiters;

        return $this;
    }
}
