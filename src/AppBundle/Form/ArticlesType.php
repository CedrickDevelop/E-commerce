<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FloatType;

class ArticlesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, [
            'required'   => true,
            'label' =>'Nom du produit',
            'attr'  => [
                'help' => 'Entrez le nom du produit avec une première lettre en majuscule']
            ])

        ->add('description',TextType::class, [
            'required'   => true,
            'label' =>'Description du produit'
            ])
        ->add('photo', FileType::class)
        ->add('prix', NumberType::class, [
            'attr'  => [
                'min'   => 0
            ]
        ])
        ->add('qte', NumberType::class, [
            'attr'  => [
                'min'   => 0
            ]
        ])
        ->add('submit', SubmitType::class, [
            'attr'  =>[
                'class'=>'btn btn-success',
                'value' => 'Rechercher',
                'placeholder' => 'Rechercher'
                ]]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Articles'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_articles';
    }


}
