<?php

namespace App\Entity;

use App\Repository\PropertySearchRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PropertySearchRepository::class)
 */
class PropertySearch
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Marque;

    /**
     * @ORM\Column(type="float")
     */
    private $max_prix;

    /**
     * @ORM\Column(type="float")
     */
    private $min_prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Modele;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getMaxPrix(): ?float
    {
        return $this->max_prix;
    }

    public function setMaxPrix(float $max_prix): self
    {
        $this->max_prix = $max_prix;

        return $this;
    }

    public function getMinPrix(): ?float
    {
        return $this->min_prix;
    }

    public function setMinPrix(float $min_prix): self
    {
        $this->min_prix = $min_prix;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->Modele;
    }

    public function setModele(string $Modele): self
    {
        $this->Modele = $Modele;

        return $this;
    }
    public function getMarque(): ?string
    {
        return $this->Marque;
    }

    public function setMarque(string $Marque): self
    {
        $this->Marque = $Marque;

        return $this;
    }
}
