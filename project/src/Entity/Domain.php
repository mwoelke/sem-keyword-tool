<?php

namespace App\Entity;

use App\Repository\DomainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DomainRepository::class)]
#[ApiResource]
class Domain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $domain;

    #[ORM\OneToMany(targetEntity: Keyword::class, mappedBy:'domain')]
    private $keywords;

    public function __construct()
    {
        $this->keywords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

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
     * Get amount of uncategorized keywords for this domain
     */
    public function getAmountUncategorized()
    {
        return $this->keywords->filter(function (Keyword $keyword) {
            return $keyword->getKeywordGroupKeywords()->count() === 0;
        })
            ->count();
    }

    /**
     * Overwrite default serialization behaviour
     *
     * @return array
     */
    public function __serialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getDomain(),
            'amount_uncategorized' => $this->getAmountUncategorized()
        ];
    }
}
