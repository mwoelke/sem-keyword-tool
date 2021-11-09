<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\KeywordGroupKeywordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KeywordGroupKeywordRepository::class)]
#[ApiResource]
class KeywordGroupKeyword
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Keyword::class, inversedBy: 'keywordGroupKeywords')]
    #[ORM\JoinColumn(nullable: false)]
    private $keyword;

    #[ORM\ManyToOne(targetEntity: KeywordGroup::class, inversedBy: 'keywordGroupKeywords')]
    #[ORM\JoinColumn(nullable: false)]
    private $keywordGroup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeyword(): ?Keyword
    {
        return $this->keyword;
    }

    public function setKeyword(?Keyword $keyword): self
    {
        $this->keyword = $keyword;

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
