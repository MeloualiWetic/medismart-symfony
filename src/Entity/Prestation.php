<?php

namespace App\Entity;

use App\Repository\PrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrestationRepository::class)
 * @ORM\Table(name="prestations")
 */
class Prestation
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
    private $libelle;

    /**
     * @ORM\Column(type="float")
     */
    private $frais;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted;

    /**
     * @ORM\OneToMany(targetEntity=DetailConsultation::class, mappedBy="prestation")
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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(float $frais): self
    {
        $this->frais = $frais;

        return $this;
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
            $detailConsultation->addPrestation($this);
        }

        return $this;
    }

    public function removeDetailConsultation(DetailConsultation $detailConsultation): self
    {
        if ($this->detailConsultations->removeElement($detailConsultation)) {
            $detailConsultation->removePrestation($this);
        }

        return $this;
    }
    /**
     * @return string
     */
    public function __toString(){
//        if(is_null($this->libelle)) {
//            return 'NULL';
//        }
        return $this->libelle;
    }

    /**
     * @return mixed
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param mixed $isDeleted
     */
    public function setIsDeleted($isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }


}
