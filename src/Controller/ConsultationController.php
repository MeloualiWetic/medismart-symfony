<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\DetailConsultation;
use App\Form\ConsultationType;
use App\Repository\ConsultationRepository;
use App\Repository\PrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/consultation")
 *
 */
class ConsultationController extends AbstractController
{
    /**
     * @Route("/", name="consultation_index", methods={"GET"})
     *
     */
    public function index(ConsultationRepository $consultationRepository): Response
    {
        return $this->render('consultation/index.html.twig', [
            'consultations' => $consultationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="consultation_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request,PrestationRepository $prestationRepository): Response
    {
        $listPrestation = $prestationRepository->findNoDeletedPrestation();
        $consultation = new Consultation();
        $reference = "REF".date("Ymd");
        $consultation->setRefernce($reference);
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('consultation_index');
        }

        return $this->render('consultation/new.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
            'listPrestation'=>$listPrestation
        ]);
    }

    /**
     * @Route("/{id}", name="consultation_show", methods={"GET"})
     */
    public function show(Consultation $consultation): Response
    {
        return $this->render('consultation/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="consultation_edit", methods={"GET","POST", "DELETE"   })
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Consultation $consultation,PrestationRepository $prestationRepository): Response
    {
        $form = $this->createForm(ConsultationType::class, $consultation);
        $detailToRmove =   $consultation ->getDetailConsultations();
        $form->handleRequest($request);
        $listPrestation = $prestationRepository->findNoDeletedPrestation();
        for ($i=0;$i<= count($listPrestation);$i++ ){
            foreach ($detailToRmove as $detail){

                if($listPrestation[$i]->getId() == $detail->getPrestation()->getId() ){
                    unset($listPrestation[$i]);

                }
            }
        }
//        unset($listPrestation[count($listPrestation)]);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('consultation_index');
        }



        return $this->render('consultation/edit.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
            'listPrestation' => $listPrestation,
        ]);
    }

    /**
     * @Route("/{id}", name="consultation_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Consultation $consultation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($consultation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('consultation_index');
    }


}
