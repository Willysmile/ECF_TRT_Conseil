<?php

namespace App\Entity;

use App\Repository\RecruitersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: RecruitersRepository::class)]
/**
 * @ORM\Entity
 * @UniqueEntity(fields={"email"},message="Cet email est déja utilisé, merci de vous connecter.")
 */
class Recruiters implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = ['ROLE_RECRUITER'];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'boolean')]
    private $is_validated = 0;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $society_name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $address;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private $zipcode;

    #[ORM\OneToMany(mappedBy: 'recruiters', targetEntity: JobAds::class)]
    private $JobAds;

    public function __construct()
    {
        $this->JobAds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getSocietyName(): ?string
    {
        return $this->society_name;
    }

    public function setSocietyName(?string $society_name): self
    {
        $this->society_name = $society_name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * @return Collection<int, JobAds>
     */
    public function getJobAds(): Collection
    {
        return $this->JobAds;
    }

    public function addJobAd(JobAds $jobAd): self
    {
        if (!$this->JobAds->contains($jobAd)) {
            $this->JobAds[] = $jobAd;
            $jobAd->setRecruiters($this);
        }

        return $this;
    }

    public function removeJobAd(JobAds $jobAd): self
    {
        if ($this->JobAds->removeElement($jobAd)) {
            // set the owning side to null (unless already changed)
            if ($jobAd->getRecruiters() === $this) {
                $jobAd->setRecruiters(null);
            }
        }

        return $this;
    }
}
