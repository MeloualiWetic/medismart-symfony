<?php

namespace App\Form;

use App\Entity\DetailConsultation;
use App\Repository\PrestationRepository;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailConsultationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',TextType::class ,array('label' => false,'required' => false, 'mapped' => false,))
            ->add('prestationLibelle',TextType::class,array('label' => false))
            ->add('frais',TextType::class,array('label' => false))
            ->add('prestation',EntityType::class,['class'=> 'App\Entity\Prestation',
                                                            'label' => false,
                                                             'query_builder' => function (EntityRepository  $repository){
                                                            return $repository->createQueryBuilder('p')
                                                                ->andWhere('p.isDeleted = :val')
                                                                ->setParameter('val', 0);
                                                             }
            ])
        ;



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetailConsultation::class,
        ]);
    }
//    public function getParent()
//    {
//    return TextType::class;
//    }
}
