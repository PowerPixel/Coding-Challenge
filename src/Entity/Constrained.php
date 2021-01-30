<?php

namespace App\Entity;

use App\Repository\ConstrainedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConstrainedRepository::class)
 */
class Constrained
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Language::class)
     * @ORM\JoinColumn(name="language", referencedColumnName="id", nullable=false)
     */
    private $language;

    /**
     * @ORM\OneToOne(targetEntity=Challenge::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="challenge", referencedColumnName="id", nullable=false)
     */
    private $challenge_id;

    public function __construct()
    {
        $this->language = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguage(): Collection
    {
        return $this->language;
    }

    public function addLanguage(Language $language): self
    {
        if (!$this->language->contains($language)) {
            $this->language[] = $language;
        }

        return $this;
    }

    public function removeLanguage(Language $language): self
    {
        $this->language->removeElement($language);

        return $this;
    }

    public function getChallengeId(): ?Challenge
    {
        return $this->challenge_id;
    }

    public function setChallengeId(?Challenge $challenge_id): self
    {
        $this->challenge_id = $challenge_id;

        return $this;
    }
}
