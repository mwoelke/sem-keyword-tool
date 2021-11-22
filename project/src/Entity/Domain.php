<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\DomainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DomainRepository::class)]
#[
    ApiResource(
        itemOperations: ['get', 'delete'],
        collectionOperations: ['get', 'post'],
        normalizationContext: ['groups' => ['domains:read']],
        denormalizationContext: ['groups' => ['domains:write']],
    )
]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'exact'])] //allow filtering by name (e.g. /api/domains?name=example.org )
class Domain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['domains:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 255)]
    #[Groups(['domains:read', 'domains:write'])]
    private $name;

    #[ORM\OneToMany(mappedBy: 'domain', targetEntity: Keyword::class)]
    private $keywords;

    #[ORM\OneToMany(mappedBy: 'domain', targetEntity: KeywordGroup::class)]
    #[Groups(['domains:read'])]
    private $keywordGroups;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
        $this->keywordGroups = new ArrayCollection();
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

    /**
     * @return Collection|Keyword[]
     */
    public function getKeywords(): Collection
    {
        return $this->keywords;
    }

    public function addKeyword(Keyword $keyword): self
    {
        if (!$this->keywords->contains($keyword)) {
            $this->keywords[] = $keyword;
            $keyword->setDomain($this);
        }

        return $this;
    }

    public function removeKeyword(Keyword $keyword): self
    {
        if ($this->keywords->removeElement($keyword)) {
            // set the owning side to null (unless already changed)
            if ($keyword->getDomain() === $this) {
                $keyword->setDomain(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|KeywordGroup[]
     */
    public function getKeywordGroups(): Collection
    {
        return $this->keywordGroups;
    }

    public function addKeywordGroup(KeywordGroup $keywordGroup): self
    {
        if (!$this->keywordGroups->contains($keywordGroup)) {
            $this->keywordGroups[] = $keywordGroup;
            $keywordGroup->setDomain($this);
        }

        return $this;
    }

    public function removeKeywordGroup(KeywordGroup $keywordGroup): self
    {
        if ($this->keywordGroups->removeElement($keywordGroup)) {
            // set the owning side to null (unless already changed)
            if ($keywordGroup->getDomain() === $this) {
                $keywordGroup->setDomain(null);
            }
        }

        return $this;
    }
}
