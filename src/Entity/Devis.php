<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private ?string $numero = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $date_effet = null;

    #[ORM\Column(type: 'float')]
    private ?float $prix = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $frequence_prix = null;

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
        return $this->date_effet;
    }

    public function setDateEffet(\DateTimeInterface $date_effet): self
    {
        $this->date_effet = $date_effet;
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
        return $this->frequence_prix;
    }

    public function setFrequencePrix(string $frequence_prix): self
    {
        $this->frequence_prix = $frequence_prix;
        return $this;
    }
}
