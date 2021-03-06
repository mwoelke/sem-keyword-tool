<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\DomainRepository;
use DateTime;
use DateTimeImmutable;
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
        denormalizationContext: ['groups' => ['domains:write']]
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

    /**
     * Get amount of unsorted keywords.
     * Api resource.
     *
     * @return integer
     */
    #[Groups(['domains:read'])]
    public function getAmountUnsortedKeywords(): int
    {
        return $this->getKeywords()->filter(function(Keyword $keyword) {
            return $keyword->getAmountKeywordGroups() === 0;
        })->count();
    }

    /**
     * Get amount of locked keywords.
     * Api resource.
     *
     * @return integer
     */
    #[Groups(['domains:read'])]
    public function getAmountLockedKeywords(): int
    {
        return $this->getKeywords()->filter(function(Keyword $keyword) {
            $locked = false;
            if($keyword->getLockedAt() !== null) {
                //set locked to false if lock is over an hour old
                $now = (new DateTimeImmutable('now', new \DateTimeZone('UTC')))->getTimestamp();
                $locked = ($now - $keyword->getLockedAt()->getTimestamp()) < 60;
            }
            return $locked;
        })->count();
    }

    /**
     * Get amount keywords.
     * Api resource.
     *
     * @return integer
     */
    #[Groups(['domains:read'])]
    public function getAmountKeywords(): int
    {
        return $this->getKeywords()->count();
    }

    /**
     * Get first unsorted keyword which is not locked.
     * Api resource.
     *
     * @return Keyword
     */
    #[Groups(['first_unsorted:read'])]
    public function getFirstUnsortedKeyword(): ?Keyword
    {
        $res = $this->getKeywords()->filter(function(Keyword $keyword) {
            $locked = false;
            if($keyword->getLockedAt() !== null) {
                //set locked to false if lock is over an hour old
                $now = (new DateTimeImmutable('now', new \DateTimeZone('UTC')))->getTimestamp();
                $locked = ($now - $keyword->getLockedAt()->getTimestamp()) < 60;
            }
            return $keyword->getAmountKeywordGroups() === 0 && !$locked;
        })->first();
        return ($res === false) ? null : $res;
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
