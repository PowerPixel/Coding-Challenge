<?php

namespace App\Entity;

use App\Repository\SolvingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolvingRepository::class)
 */
class Solving
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
    private $completed_test_amount;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false)
     */
    private $user_id;

    /**
     * @ORM\OneToOne(targetEntity=Exercise::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="exercise", referencedColumnName="id", nullable=false)
     */
    private $exercise_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompletedTestAmount(): ?int
    {
        return $this->completed_test_amount;
    }

    public function setCompletedTestAmount(int $completed_test_amount): self
    {
        $this->completed_test_amount = $completed_test_amount;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getExerciseId(): ?Exercise
    {
        return $this->exercise_id;
    }

    public function setExerciseId(Exercise $exercise_id): self
    {
        $this->exercise_id = $exercise_id;

        return $this;
    }
}
