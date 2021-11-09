<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\KeywordGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Tools\ResolveTargetEntityListener;

#[ORM\Entity(repositoryClass:KeywordGroupRepository::class)]
#[ApiResource]
class KeywordGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $type;

    #[ORM\OneToMany(targetEntity:KeywordGroupKeyword::class, mappedBy:'keywordGroup')]
    private $keywordGroupKeywords;

    public function __construct()
    {
        $this->keywordGroupKeywords = new ArrayCollection();
    }

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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|KeywordGroupKeyword[]
     */
    public function getKeywordGroupKeywords(): Collection
    {
        return $this->keywordGroupKeywords;
    }

    public function addKeywordGroupKeyword(KeywordGroupKeyword $keywordGroupKeyword): self
    {
        if (!$this->keywordGroupKeywords->contains($keywordGroupKeyword)) {
            $this->keywordGroupKeywords[] = $keywordGroupKeyword;
            $keywordGroupKeyword->setKeywordGroup($this);
        }

        return $this;
    }

    public function removeKeywordGroupKeyword(KeywordGroupKeyword $keywordGroupKeyword): self
    {
        if ($this->keywordGroupKeywords->removeElement($keywordGroupKeyword)) {
            // set the owning side to null (unless already changed)
            if ($keywordGroupKeyword->getKeywordGroup() === $this) {
                $keywordGroupKeyword->setKeywordGroup(null);
            }
        }

        return $this;
    }
}
