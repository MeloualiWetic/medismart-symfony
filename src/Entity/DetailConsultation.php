<?php

namespace App\Entity;

use App\Repository\DetailConsultationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailConsultationRepository::class)
 * @ORM\Table(name="details_consultations")
 */
class DetailConsultation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $frais;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
     private $prestationLibelle;

    /**
     * @ORM\ManyToOne(targetEntity=Consultation::class, inversedBy="detailConsultations",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false, name="consultation_id", referencedColumnName="id")
     */
    private $consultation;

    /**
     * @ORM\ManyToOne(targetEntity=Prestation::class, inversedBy="detailConsultations",)
     * @ORM\JoinColumn(nullable=false,name="prestation_id", referencedColumnName="id")
     */
    private $prestation;

    public function __construct()
    {
        $this->prestation = new Prestation();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return mixed
     */
    public function getPrestationLibelle()
    {
        return $this->prestationLibelle;
    }

    /**
     * @param mixed $prestationLibelle
     */
    public function setPrestationLibelle($prestationLibelle): void
    {
        $this->prestationLibelle = $prestationLibelle;
    }


    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): self
    {
        $this->consultation = $consultation;

        return $this;
    }


    public function getPrestation(): ?Prestation
    {
        return $this->prestation;
    }

    public function setPrestation(?Prestation $prestation): self
    {
        $this->prestation = $prestation;

        return $this;
    }

}
