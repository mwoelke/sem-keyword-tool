<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssignmentRuleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AssignmentRuleRepository::class)]
#[
    ApiResource(
        itemOperations: ['get', 'delete', 'put'],
        collectionOperations: ['get', 'post'],
        normalizationContext: ['groups' => ['assignmentRules:read']],
        denormalizationContext: ['groups' => ['assignmentRules:write']],
        attributes: ['pagination_enabled' => false]
    )
]
class AssignmentRule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['assignmentRules:read'])]
    private $id;

    #[ORM\ManyToOne(targetEntity: Domain::class, inversedBy: 'assignmentRules')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['assignmentRules:read', 'assignmentRules:write'])]
    #[Assert\NotBlank()]
    private $domain;

    #[ORM\Column(type: 'string', length: 500)]
    #[Groups(['assignmentRules:read', 'assignmentRules:write'])]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 500)]
    private $regexPattern;

    #[ORM\ManyToOne(targetEntity: KeywordGroup::class, inversedBy: 'assignmentRules')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['assignmentRules:read', 'assignmentRules:write'])]
    #[Assert\NotBlank()]
    private $keywordGroup;

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

    public function getKeywordGroup(): ?KeywordGroup
    {
        return $this->keywordGroup;
    }

    public function setKeywordGroup(?KeywordGroup $keywordGroup): self
    {
        $this->keywordGroup = $keywordGroup;

        return $this;
    }
}
