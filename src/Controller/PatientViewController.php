<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Repository\ConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class PatientViewController extends AbstractController
{
    /**
     * @Route("/patient/view", name="patient_view")
     */
    public function index(UserInterface $user,ConsultationRepository $consultationRepository): Response
    {
        $consultations = $consultationRepository->findConsultationByUtilisateur($user);
        return $this->render('patient_view/index.html.twig', [
            'controller_name' => 'PatientViewController',
            'consultations'=>$consultations
        ]);
    }

    /**
     * @Route("/patient/view/{id}", name="patient_consultation_show", methods={"GET"})
     */
    public function show(Consultation $consultation): Response
    {
        return $this->render('consultation/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }
}
