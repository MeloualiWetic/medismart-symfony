<?php

namespace App\Controller;

use App\Entity\DetailConsultation;
use App\Form\DetailConsultationType;
use App\Repository\DetailConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/detailconsultation")
 */
class DetailConsultationController extends AbstractController
{
    /**
     * @Route("/", name="detail_consultation_index", methods={"GET"})
     */
    public function index(DetailConsultationRepository $detailConsultationRepository): Response
    {
        return $this->render('detail_consultation/index.html.twig', [
            'detail_consultations' => $detailConsultationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="detail_consultation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $detailConsultation = new DetailConsultation();
        $form = $this->createForm(DetailConsultationType::class, $detailConsultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detailConsultation);
            $entityManager->flush();

            return $this->redirectToRoute('detail_consultation_index');
        }

        return $this->render('detail_consultation/new.html.twig', [
            'detail_consultation' => $detailConsultation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_consultation_show", methods={"GET"})
     */
    public function show(DetailConsultation $detailConsultation): Response
    {
        return $this->render('detail_consultation/show.html.twig', [
            'detail_consultation' => $detailConsultation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="detail_consultation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DetailConsultation $detailConsultation): Response
    {
        $form = $this->createForm(DetailConsultationType::class, $detailConsultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('detail_consultation_index');
        }

        return $this->render('detail_consultation/edit.html.twig', [
            'detail_consultation' => $detailConsultation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/detailconsultation/{id}", name="detail_consultation_delete", methods={"GET", "DELETE"})
     */
    public function delete(Request $request, DetailConsultation $detailConsultation): Response
    {
        $idConsultation = $detailConsultation->getConsultation()->getId();
//        if ($this->isCsrfTokenValid('delete'.$detailConsultation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailConsultation);
            $entityManager->flush();
//        }


        return $this->redirectToRoute('consultation_edit',array('id' => $idConsultation));
    }
}
