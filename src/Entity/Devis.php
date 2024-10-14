<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['devis:read', 'devis:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $numero = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['devis:read', 'devis:write'])]
    private ?\DateTimeInterface $dateEffet = null;

    #[ORM\Column]
    #[Groups(['devis:read', 'devis:write'])]
    private ?float $prix = null;

    #[ORM\Column(length: 255)]
    #[Groups(['devis:read', 'devis:write'])]
    private ?string $frequencePrix = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'devis')]
    #[Groups(['devis:read', 'devis:write'])]
    private ?Client $client = null;

    #[ORM\ManyToMany(targetEntity: Voiture::class, inversedBy: 'devis')]
    #[Groups(['devis:read', 'devis:write'])]
    #[MaxDepth(1)]
    private Collection $voitures;

    public function __construct()
    {
        $this->voitures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;
        return $this;
    }

    public function getDateEffet(): ?\DateTimeInterface
    {
        return $this->dateEffet;
    }

    public function setDateEffet(\DateTimeInterface $dateEffet): self
    {
        $this->dateEffet = $dateEffet;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getFrequencePrix(): ?string
    {
        return $this->frequencePrix;
    }

    public function setFrequencePrix(string $frequencePrix): self
    {
        $this->frequencePrix = $frequencePrix;
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
     * @return Collection<int, Voiture>
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }

    public function addVoiture(Voiture $voiture): static
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures->add($voiture);
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): static
    {
        $this->voitures->removeElement($voiture);

        return $this;
    }
}
