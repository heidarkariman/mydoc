<?php

namespace App\Entity;

use App\Repository\ScandocTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScandocTypeRepository::class)]
class ScandocType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'scandoc_type', targetEntity: Scandoc::class)]
    private Collection $scandocs;

    public function __construct()
    {
        $this->scandocs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Scandoc>
     */
    public function getScandocs(): Collection
    {
        return $this->scandocs;
    }

    public function addScandoc(Scandoc $scandoc): self
    {
        if (!$this->scandocs->contains($scandoc)) {
            $this->scandocs->add($scandoc);
            $scandoc->setScandocType($this);
        }

        return $this;
    }

    public function removeScandoc(Scandoc $scandoc): self
    {
        if ($this->scandocs->removeElement($scandoc)) {
            // set the owning side to null (unless already changed)
            if ($scandoc->getScandocType() === $this) {
                $scandoc->setScandocType(null);
            }
        }

        return $this;
    }
}
