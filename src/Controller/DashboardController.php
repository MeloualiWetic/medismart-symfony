<?php

namespace App\Controller;

use App\Repository\ConsultationRepository;
use App\Repository\PrestationRepository;
use App\Repository\UtilisateurRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin/dashboard")
 *
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard",methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index( PrestationRepository $prestationRepository, ConsultationRepository $consultationRepository, UtilisateurRepository $utilisateurRepository): Response
    {
//        DONUT CHART
        $consultationPaye = $consultationRepository->countConsultationPaye();
        $consultationNoPaye = $consultationRepository->countConsultationNoPaye();
        $outputDonutChart [] = (int)$consultationPaye;
        $outputDonutChart [] = (int)$consultationNoPaye;
        $outputDonutChart = new Response(json_encode($outputDonutChart));
        $prestationCount = $prestationRepository->countPrestatoin();
       $consultationCount =  $consultationRepository->countConsultation();
       $countPatient = $utilisateurRepository->countUtilisateurs();
       $consultationByMonth []  = $consultationRepository->countConsultationByMonth();
       $output = [];
       $k = 1;
       for ( $j=0;$j< count($consultationByMonth);$j++){
            for ( $i=0;$i<12;$i++){
               if($consultationByMonth[$j]['byMonth']== $k){
                   $output[$i] = (int)$consultationByMonth[$j]['count'];
               }else{
                   $output[$i] = 0;
               }
               $k++;
           }

        }
        $output = new Response(json_encode($output));
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'countPrestation'=>$prestationCount,
            'countConsultation'=>$consultationCount,
            'countPatient' => $countPatient,
            'output'=> $output,
            'outputDonutChart' => $outputDonutChart,

        ]);
    }
}
