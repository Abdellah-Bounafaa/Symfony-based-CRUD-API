<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['client:read', 'client:write', 'devis:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['client:read', 'client:write', 'devis:read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['client:read', 'client:write', 'devis:read'])]
    private ?string $prenom = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['client:read', 'client:write', 'devis:read'])]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['client:read', 'client:write', 'devis:read'])]
    private ?bool $estPersonne = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Devis::class)]
    #[Groups(['client:read', 'client:write'])]
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    public function getEstPersonne(): ?bool
    {
        return $this->estPersonne;
    }

    public function setEstPersonne(bool $estPersonne): self
    {
        $this->estPersonne = $estPersonne;
        return $this;
    }

    /**
     * @return Collection|Devis[]
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevis(Devis $devis): self
    {
        if (!$this->devis->contains($devis)) {
            $this->devis[] = $devis;
            $devis->setClient($this);
        }

        return $this;
    }

    public function removeDevis(Devis $devis): self
    {
        if ($this->devis->removeElement($devis)) {
            // set the owning side to null (unless already changed)
            if ($devis->getClient() === $this) {
                $devis->setClient(null);
            }
        }

        return $this;
    }
}
