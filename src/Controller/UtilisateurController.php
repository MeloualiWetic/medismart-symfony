<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/utilisateur")
 */
class UtilisateurController extends AbstractController
{

    private $encoder;
    public function __constructor(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }
    /**
     * @Route("/", name="utilisateur_index", methods={"GET"})
     *@IsGranted("ROLE_ADMIN")
     */
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        $errorMsg = " ";
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findNoDeletedUtilisateur(),
            'errorMsg' => $errorMsg
        ]);
    }

    /**
     * @Route("/new", name="utilisateur_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur->setIsDeleted(false);
            // encode the plain password
            $utilisateur->setPassword(
                $passwordEncoder->encodePassword(
                    $utilisateur,
                    $form->get('password')->getData()
                )
            );
        $utilisateur->setRoles(["ROLE_USER"]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="utilisateur_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="utilisateur_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Utilisateur $utilisateur): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="utilisateur_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Utilisateur $utilisateur,UtilisateurRepository $utilisateurRepository): Response
    {
        $consultations = $utilisateur->getConsultations();
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            if(count($consultations)>0){
                $errorMsg = "Veuillez d'abord supprimer les consultations liées";

                return $this->render('utilisateur/index.html.twig', [
                    'utilisateurs' => $utilisateurRepository->findNoDeletedUtilisateur(),
                    'errorMsg' => $errorMsg,


                ]);
            }else{
                $entityManager->remove($utilisateur);
                $entityManager->flush();
                return $this->redirectToRoute('utilisateur_index');
            }
        }


    }
}
