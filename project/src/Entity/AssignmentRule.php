<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssignmentRuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssignmentRuleRepository::class)]
#[ApiResource]
class AssignmentRule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Domain::class, inversedBy: 'assignmentRules')]
    #[ORM\JoinColumn(nullable: false)]
    private $domain;

    #[ORM\Column(type: 'string', length: 500)]
    private $regexPattern;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDomain(): ?Domain
    {
        return $this->domain;
    }

    public function setDomain(?Domain $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getRegexPattern(): ?string
    {
        return $this->regexPattern;
    }

    public function setRegexPattern(string $regexPattern): self
    {
        $this->regexPattern = $regexPattern;

        return $this;
    }
}
