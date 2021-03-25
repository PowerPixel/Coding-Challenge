<?php

namespace App\Entity;

use App\Repository\ComposedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComposedRepository::class)
 */
class Composed
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $points_amount;

    /**
     * @ORM\ManyToMany(targetEntity=Exercise::class)
     * @ORM\JoinColumn(name="exercice", referencedColumnName="id", nullable=false,onDelete="CASCADE")
     */
    private $exercise_id;

    /**
     * @ORM\OneToOne(targetEntity=Challenge::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="challenge", referencedColumnName="id", nullable=false,onDelete="CASCADE")
     */
    private $challenge_id;

    public function __construct()
    {
        $this->exercise_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPointsAmount(): ?int
    {
        return $this->points_amount;
    }

    public function setPointsAmount(int $points_amount): self
    {
        $this->points_amount = $points_amount;

        return $this;
    }

    /**
     * @return Collection|Exercise[]
     */
    public function getExerciseId(): Collection
    {
        return $this->exercise_id;
    }

    public function addExerciseId(Exercise $exerciseId): self
    {
        if (!$this->exercise_id->contains($exerciseId)) {
            $this->exercise_id[] = $exerciseId;
        }

        return $this;
    }

    public function removeExerciseId(Exercise $exerciseId): self
    {
        $this->exercise_id->removeElement($exerciseId);

        return $this;
    }

    public function getChallengeId(): ?Challenge
    {
        return $this->challenge_id;
    }

    public function setChallengeId(Challenge $challenge_id): self
    {
        $this->challenge_id = $challenge_id;

        return $this;
    }
}
