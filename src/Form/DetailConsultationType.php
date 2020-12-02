<?php

namespace App\Form;

use App\Entity\DetailConsultation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailConsultationType extends AbstractType
{
    public  function prestation__construct(){

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('frais')
//            ->add('prestation',EntityType::class,['class'=> 'App\Entity\Prestation'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DetailConsultation::class,
        ]);
    }
}
