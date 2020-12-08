<?php

namespace App\Form;

use App\Entity\DetailConsultation;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('id',null ,array('label' => false,'required' => false,))
            ->add('frais',null,array('label' => false))
            ->add('prestation',EntityType::class,['class'=> 'App\Entity\Prestation','label' => false])
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
