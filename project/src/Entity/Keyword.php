<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\KeywordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KeywordRepository::class)]
#[ApiResource]
class Keyword
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 500)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 1, max: 500)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Domain::class, inversedBy: 'keywords')]
    #[ORM\JoinColumn(nullable: false)]
    private $domain;

    #[ORM\ManyToMany(targetEntity: KeywordGroup::class, inversedBy: 'keywords')]
    #[ORM\JoinTable(name: "keywords_keywordgroups")]
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
}
