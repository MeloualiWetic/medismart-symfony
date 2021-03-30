<?php

namespace App\Controller;

use App\Entity\TypePaiement;
use App\Form\TypePaiementType;
use App\Repository\TypePaiementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/type/paiement")
 */
class TypePaiementController extends AbstractController
{
    /**
     * @Route("/", name="type_paiement_index", methods={"GET"})
     */
    public function index(TypePaiementRepository $typePaiementRepository): Response
    {
        return $this->render('type_paiement/index.html.twig', [
            'type_paiements' => $typePaiementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_paiement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typePaiement = new TypePaiement();
        $form = $this->createForm(TypePaiementType::class, $typePaiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typePaiement);
            $entityManager->flush();

            return $this->redirectToRoute('type_paiement_index');
        }

        return $this->render('type_paiement/new.html.twig', [
            'type_paiement' => $typePaiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_paiement_show", methods={"GET"})
     */
    public function show(TypePaiement $typePaiement): Response
    {
        return $this->render('type_paiement/show.html.twig', [
            'type_paiement' => $typePaiement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_paiement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypePaiement $typePaiement): Response
    {
        $form = $this->createForm(TypePaiementType::class, $typePaiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_paiement_index');
        }

        return $this->render('type_paiement/edit.html.twig', [
            'type_paiement' => $typePaiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_paiement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypePaiement $typePaiement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typePaiement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typePaiement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_paiement_index');
    }
}
