<?php

namespace App\Form;

use App\Entity\Consultation;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('utilisateur',EntityType::class,['class'=> 'App\Entity\Utilisateur',
                                                                'query_builder' => function (EntityRepository  $repository){
                                                                return $repository->createQueryBuilder('p')
                                                                    ->andWhere('p.isDeleted = :val')
                                                                    ->setParameter('val', 0);
    }] )
            ->add('dateDebut',DateTimeType::class, [
                        'widget' => 'single_text'])
            ->add('dataFin',DateTimeType::class, [
                    'widget' => 'single_text',])
            ->add('description')
            ->add('refernce')
            ->add('statut')
            ->add('detailConsultations',  CollectionType::class, [
                'entry_type' => DetailConsultationType::class,
                'label' => false,
                'entry_options' => [
                    'label' => false
                ],
                'by_reference' => false,
                // this allows the creation of new forms and the prototype too
                'allow_add' => true,
                // self explanatory, this one allows the form to be removed
                'allow_delete' => true
            ])
//            ->add('prestation',EntityType::class,['class'=> 'App\Entity\Prestation',
//                'query_builder' => function (EntityRepository  $repository){
//                    return $repository->createQueryBuilder('p')
//                        ->andWhere('p.isDeleted = :val')
//                        ->setParameter('val', 0);
//                }])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }

//    public function getParent()
//    {
//        return parent::getParent(); // TODO: Change the autogenerated stub
//    }
}
