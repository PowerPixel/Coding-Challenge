<?php

namespace App\Entity;

use App\Repository\ParticipateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipateRepository::class)
 */
class Participate
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
    private $user_points;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToMany(targetEntity=Challenge::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="challenge", referencedColumnName="id", nullable=false)
     */
    private $challenge_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserPoints(): ?int
    {
        return $this->user_points;
    }

    public function setUserPoints(int $user_points): self
    {
        $this->user_points = $user_points;

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
