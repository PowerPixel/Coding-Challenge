<?php

namespace App\Entity;

use App\Repository\ExerciseRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=ExerciseRepository::class)
 * @ApiResource(collectionOperations={"get"},
 *              itemOperations={"get"})
 */
class Exercise
{
    public static $PATH_TO_EXERCISES_FOLDER = "../exercises";
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $difficulty;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $folder_path;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $creator;

    /**
     * @ORM\Column(type="datetime")
     */
    private $submit_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $approved_date;

    /**
     * @ORM\ManyToOne(targetEntity=ExerciseState::class)
     * @ORM\JoinColumn(name="exercisestate", referencedColumnName="id", nullable=false)
     */
    private $state;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(int $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFolderPath(): ?string
    {
        return Exercise::$PATH_TO_EXERCISES_FOLDER . $this->folder_path;
    }

    public function setFolderPath(string $folder_path): self
    {
        $this->folder_path = $folder_path;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getSubmitDate(): ?\DateTimeInterface
    {
        return $this->submit_date;
    }

    public function setSubmitDate(\DateTimeInterface $submit_date): self
    {
        $this->submit_date = $submit_date;

        return $this;
    }

    public function getApprovedDate(): ?\DateTimeInterface
    {
        return $this->approved_date;
    }

    public function setApprovedDate(?\DateTimeInterface $approved_date): self
    {
        $this->approved_date = $approved_date;

        return $this;
    }

    public function getState(): ?ExerciseState
    {
        return $this->state;
    }

    public function setState(?ExerciseState $state): self
    {
        $this->state = $state;

        return $this;
    }
}
