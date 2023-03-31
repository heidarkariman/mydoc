<?php

namespace App\Entity;

use App\Repository\ScanformTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScanformTypeRepository::class)]
class ScanformType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'scanform_type', targetEntity: Scanform::class)]
    private Collection $scanforms;

    public function __construct()
    {
        $this->scanforms = new ArrayCollection();
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
     * @return Collection<int, Scanform>
     */
    public function getScanforms(): Collection
    {
        return $this->scanforms;
    }

    public function addScanform(Scanform $scanform): self
    {
        if (!$this->scanforms->contains($scanform)) {
            $this->scanforms->add($scanform);
            $scanform->setScanformType($this);
        }

        return $this;
    }

    public function removeScanform(Scanform $scanform): self
    {
        if ($this->scanforms->removeElement($scanform)) {
            // set the owning side to null (unless already changed)
            if ($scanform->getScanformType() === $this) {
                $scanform->setScanformType(null);
            }
        }

        return $this;
    }
}
