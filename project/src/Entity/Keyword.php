<?php

namespace App\Entity;

use App\Repository\KeywordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KeywordRepository::class)
 */
class Keyword
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $keyword;

    /**
     * @ORM\ManyToOne(targetEntity=Domain::class, inversedBy="keywords")
     * @ORM\JoinColumn(nullable=false)
     */
    private $domain;

    /**
     * @ORM\OneToMany(targetEntity=KeywordGroupKeyword::class, mappedBy="keyword")
     */
    private $keywordGroupKeywords;

    public function __construct()
    {
        $this->keywordGroupKeywords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    public function setKeyword(string $keyword): self
    {
        $this->keyword = $keyword;

        return $this;
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
            $keywordGroupKeyword->setKeyword($this);
        }

        return $this;
    }

    public function removeKeywordGroupKeyword(KeywordGroupKeyword $keywordGroupKeyword): self
    {
        if ($this->keywordGroupKeywords->removeElement($keywordGroupKeyword)) {
            // set the owning side to null (unless already changed)
            if ($keywordGroupKeyword->getKeyword() === $this) {
                $keywordGroupKeyword->setKeyword(null);
            }
        }

        return $this;
    }
}
