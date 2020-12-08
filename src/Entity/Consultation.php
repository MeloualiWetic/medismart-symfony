<?php

namespace App\Entity;

use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConsultationRepository", repositoryClass=ConsultationRepository::class)
 * @ORM\Table(name="consultations")
 */
class Consultation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dataFin;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $description;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $refernce;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="consultations")
     * @ORM\JoinColumn(nullable=false,name="prestation_id", referencedColumnName="id")
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity=DetailConsultation::class, mappedBy="consultation",cascade={"persist","remove"})
     */
    private $detailConsultations;

    public function __construct()
    {
        $this->detailConsultations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDataFin(): ?\DateTimeInterface
    {
        return $this->dataFin;
    }

    public function setDataFin(\DateTimeInterface $dataFin): self
    {
        $this->dataFin = $dataFin;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRefernce(): ?string
    {
        return $this->refernce;
    }

    public function setRefernce(string $refernce): self
    {
        $this->refernce = $refernce;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getUtilisateur(): ?utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
    public function getUtilisateurNom(): ?string
    {
        return $this->utilisateur->getNom();
    }

    /**
     * @return Collection|DetailConsultation[]
     */
    public function getDetailConsultations(): Collection
    {
        return $this->detailConsultations;
    }

    public function addDetailConsultation(DetailConsultation $detailConsultation): self
    {
        if (!$this->detailConsultations->contains($detailConsultation)) {
            $this->detailConsultations[] = $detailConsultation;
            $detailConsultation->setConsultation($this);
        }

        return $this;
    }

    public function removeDetailConsultation(DetailConsultation $detailConsultation): self
    {
        if ($this->detailConsultations->removeElement($detailConsultation)) {
            // set the owning side to null (unless already changed)
            if ($detailConsultation->getConsultation() === $this) {
                $detailConsultation->setConsultation(null);
            }
        }

        return $this;
    }

}
