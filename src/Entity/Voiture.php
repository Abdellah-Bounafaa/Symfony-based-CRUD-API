<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['voiture:read', 'voiture:write', 'devis:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['voiture:read', 'voiture:write', 'devis:read'])]
    private ?string $numero_immatriculation = null;

    #[ORM\Column(name: '`usage`', type: 'string', length: 255)]
    #[Groups(['voiture:read', 'voiture:write', 'devis:read'])]
    private ?string $usage = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['voiture:read', 'voiture:write', 'devis:read'])]
    private ?string $emplacement = null;

    #[ORM\Column(type: 'date')]
    #[Groups(['voiture:read', 'voiture:write', 'devis:read'])]
    private ?\DateTimeInterface $date_achat = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'voitures')]
    #[Groups(['voiture:read', 'voiture:write', 'devis:read'])]
    private ?Client $client = null;

    #[ORM\ManyToMany(targetEntity: Devis::class, mappedBy: 'voitures')]
    #[Groups(['voiture:read', 'voiture:write'])]
    #[MaxDepth(1)]
    private Collection $devis;

    public function __construct()
    {
        $this->devis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroImmatriculation(): ?string
    {
        return $this->numero_immatriculation;
    }

    public function setNumeroImmatriculation(string $numero_immatriculation): self
    {
        $this->numero_immatriculation = $numero_immatriculation;
        return $this;
    }

    public function getUsage(): ?string
    {
        return $this->usage;
    }

    public function setUsage(string $usage): self
    {
        $this->usage = $usage;
        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): self
    {
        $this->emplacement = $emplacement;
        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->date_achat;
    }

    public function setDateAchat(\DateTimeInterface $date_achat): self
    {
        $this->date_achat = $date_achat;
        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return Collection<int, Devis>
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): static
    {
        if (!$this->devis->contains($devi)) {
            $this->devis->add($devi);
            $devi->addVoiture($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): static
    {
        if ($this->devis->removeElement($devi)) {
            $devi->removeVoiture($this);
        }

        return $this;
    }
}
