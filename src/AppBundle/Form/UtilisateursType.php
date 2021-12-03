<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, [
            'attr'  => [
                'class' => 'form-control'
            ]
        ])
        ->add('prenom', TextType::class, [
            'attr'  => [
                'class' => 'form-control'
            ]
        ])
        ->add('email', EmailType::class, [
            'attr'  => [
                'class' => 'form-control'
            ]
        ])
        ->add('role', ChoiceType::class, [
            'choices'   =>  [
                'Admin'     =>1,
                'Client'    =>2,
                'RH'        =>3
            ],
            'attr'  => [
                'class' => 'form-control'
            ]
        ])
        ->add('password', PasswordType::class, [
            'attr'      => [
                'class'     => 'form-control'
            ]
        ])
        ->add('photo', FileType::class,[
            'required'  => false
        ])
        // ->add('password', RepeatedType::class, [
        //     'type'              => PasswordType::class,
        //     'invalid_message'  =>'Les mots de passe doivent coincider',
        //     'required'          => true,
        //     'first_options'     =>['label'  =>'Mot de Passe'],
        //     'second_options'     =>['label'  =>'Mot de Passe Confirmation'],
        //     'attr'              => [
        //         'class'     => 'form-control'
        //     ]
        // ])
        ->add('submit', SubmitType::class, [
            'attr'  => [
                'class' => 'btn btn-primary mt-3'
            ]
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Utilisateurs'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_utilisateurs';
    }


}
