<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\KeywordGroupRepository;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: KeywordGroupRepository::class)]
#[
    ApiResource(
        itemOperations: ['get', 'delete', 'patch'], //allow patch here to modify name
        collectionOperations: ['get', 'post'],
        normalizationContext: ['groups' => ['keyword_groups:read']],
        denormalizationContext: ['groups' => ['keyword_groups:write']],
        attributes: ['pagination_items_per_page' => 30], //show 30 entries per page (/api/keyword_groups?page=1 etc.)
        formats: ['jsonld', 'json', 'csv' => ['text/csv']] //allow csv export 
    )
]
#[UniqueEntity(fields: ['name', 'domain'])] //keyword group has to be unique for given domain
class KeywordGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['keyword_groups:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 255)]
    #[Groups(['keyword_groups:read', 'keyword_groups:write'])]
    #[ApiFilter(SearchFilter::class, properties: ['name' => 'exact'])] //allow filtering by name (e.g. /api/keyword_groups?name=foo )
    private $name;

    #[ORM\ManyToMany(targetEntity: Keyword::class, mappedBy: 'keywordGroups')]
    private $keywords;

    #[ORM\ManyToOne(targetEntity: Domain::class, inversedBy: 'keywordGroups')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['keyword_groups:read','keyword_groups:write'])]
    #[ApiFilter(SearchFilter::class, properties: ['domain.id' => 'exact'])] //allow filtering by domain id
    private $domain;

    #[ORM\OneToMany(mappedBy: 'keywordGroup', targetEntity: AssignmentRule::class)]
    #[Groups(['keyword_groups:read','keyword_groups:write'])]
    private $assignmentRules;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
        $this->assignmentRules = new ArrayCollection();
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
            $keyword->addKeywordGroup($this);
        }

        return $this;
    }

    /**
     * Get amount of keywords.
     * Api resource.
     *
     * @return integer
     */
    #[Groups(['keyword_groups:read'])]
    public function getAmountKeywords(): int
    {
        return $this->keywords->count();
    }

    public function removeKeyword(Keyword $keyword): self
    {
        if ($this->keywords->removeElement($keyword)) {
            $keyword->removeKeywordGroup($this);
        }

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
     * @return Collection|AssignmentRule[]
     */
    public function getAssignmentRules(): Collection
    {
        return $this->assignmentRules;
    }

    public function addAssignmentRule(AssignmentRule $assignmentRule): self
    {
        if (!$this->assignmentRules->contains($assignmentRule)) {
            $this->assignmentRules[] = $assignmentRule;
            $assignmentRule->setKeywordGroup($this);
        }

        return $this;
    }

    public function removeAssignmentRule(AssignmentRule $assignmentRule): self
    {
        if ($this->assignmentRules->removeElement($assignmentRule)) {
            // set the owning side to null (unless already changed)
            if ($assignmentRule->getKeywordGroup() === $this) {
                $assignmentRule->setKeywordGroup(null);
            }
        }

        return $this;
    }
}
