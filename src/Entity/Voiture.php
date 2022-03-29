<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modele;

    /**
     * @ORM\Column(type="integer")
     */
    public $nb_places;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couleur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Image;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="voiture")
     */
    private $Voiture;

    /**
     * @ORM\Column(type="integer")
     */
    public $code_voiture;

    public function __construct()
    {
        $this->Voiture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?int
    {
        return $this->matricule;
    }

    public function setMatricule(int $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nb_places;
    }

    public function setNbPlaces(int $nb_places): self
    {
        $this->nb_places = $nb_places;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getImage()
    {
        return $this->Image;
    }

    public function setImage( $Image): self
    {
        $this->Image = $Image;

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

    /**
     * @return Collection|Location[]
     */
    public function getVoiture(): Collection
    {
        return $this->Voiture;
    }

    public function addVoiture(Location $voiture): self
    {
        if (!$this->Voiture->contains($voiture)) {
            $this->Voiture[] = $voiture;
            $voiture->setVoiture($this);
        }

        return $this;
    }

    public function removeVoiture(Location $voiture): self
    {
        if ($this->Voiture->removeElement($voiture)) {
            // set the owning side to null (unless already changed)
            if ($voiture->getVoiture() === $this) {
                $voiture->setVoiture(null);
            }
        }

        return $this;
    }

    public function getCodeVoiture(): ?int
    {
        return $this->code_voiture;
    }

    public function setCodeVoiture(int $code_voiture): self
    {
        $this->code_voiture = $code_voiture;

        return $this;
    }
}
