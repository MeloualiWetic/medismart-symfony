<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 * @ORM\Table(name="patients")
 */
class Patient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $telephone;

    /**
     * @ORM\OneToOne(targetEntity=Adresse::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=Consultation::class, mappedBy="patient")
     */
    private $consultations;

    public function __construct()
    {
        $this->consultations = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|Consultation[]
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): self
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations[] = $consultation;
            $consultation->setPatient($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->removeElement($consultation)) {
            // set the owning side to null (unless already changed)
            if ($consultation->getPatient() === $this) {
                $consultation->setPatient(null);
            }
        }

        return $this;
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom." ".$this->prenom; 
    }
}
