<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssignmentRuleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AssignmentRuleRepository::class)]
#[
    ApiResource(
        itemOperations: ['get', 'delete', 'put'],
        collectionOperations: ['get', 'post'],
        normalizationContext: ['groups' => ['assignmentRules:read']],
        denormalizationContext: ['groups' => ['assignmentRules:write']]
    )
]
#[UniqueEntity(fields: ['keywordGroup', 'regexPattern'])] //rule has to be unique for given keywordGroup
class AssignmentRule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['assignmentRules:read', 'keyword_groups:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 500)]
    #[Groups(['assignmentRules:read', 'assignmentRules:write', 'keyword_groups:read'])]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 500)]
    #[CustomAssert\ValidRegex()]
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