<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LanguageRepository::class)
 */
class Language
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $code_snippet;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $name_code;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCodeSnippet(): ?string
    {
        return $this->code_snippet;
    }

    public function setCodeSnippet(string $code): self
    {
        $this->code_snippet = $code;

        return $this;
    }

    public function getNameCode(): ?string
    {
        return $this->name_code;
    }

    public function setNameCode(string $name_code): self
    {
        $this->code_snippet = $name_code;

        return $this;
    }
}
