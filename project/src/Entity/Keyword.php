<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\KeywordRepository;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: KeywordRepository::class)]
#[
    ApiResource(
        itemOperations: ['get', 'delete'],
        collectionOperations: ['get', 'post'],
        normalizationContext: ['groups' => ['keywords:read']],
        denormalizationContext: ['groups' => ['keywords:write']],
        attributes: ['pagination_items_per_page' => 15] //show 15 entries per page (/api/keywords?page=1 etc.)
    )
]
#[UniqueEntity(fields: ['name', 'domain'])] //keyword has to be unique for given domain
class Keyword
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['keywords:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 500)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 500)] //if anyone puts more than 500 chars in a search engine I feel sorry for them
    #[Groups(['keywords:write', 'keywords:read'])]
    private $name;

    #[ORM\ManyToOne(targetEntity: Domain::class, inversedBy: 'keywords')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['keywords:write', 'keywords:read'])]
    #[ApiFilter(SearchFilter::class, properties: ['domain.id' => 'exact'])] //allow filtering by domain id
    private $domain;

    #[ORM\ManyToMany(targetEntity: KeywordGroup::class, inversedBy: 'keywords')]
    #[ORM\JoinTable(name: "keywords_keywordgroups")]
    #[Groups(['keywords:write', 'keywords:read'])]
    #[ApiFilter(SearchFilter::class, properties: ['keyword_group.id' => 'exact'])] //allow filtering by keywordGroup id
    private $keywordGroups;

    public function __construct()
    {
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
        }

        return $this;
    }

    public function removeKeywordGroup(KeywordGroup $keywordGroup): self
    {
        $this->keywordGroups->removeElement($keywordGroup);

        return $this;
    }

    /**
     * Get amount of asigned keyword groups
     * Used for api
     *
     * @return integer
     */
    #[Groups(['keywords:read'])]
    public function getAmountKeywordGroups(): int
    {
        return $this->keywordGroups->count();
    }
}
