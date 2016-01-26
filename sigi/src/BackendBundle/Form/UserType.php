<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userType', null,array('label' => 'Tipo de usuario','attr' => array('class'=>'form-control')))
            ->add('username', null,array('label' => 'Nombre de usuario','attr' => array('class'=>'form-control')))
            ->add('rut', null,array('label' => 'Rut','attr' => array('class'=>'form-control')))
            ->add('name', null,array('label' => 'Nombre','attr' => array('class'=>'form-control')))
            ->add('middleName', null,array('label' => 'Segundo Nombre','attr' => array('class'=>'form-control')))
            ->add('lastName', null,array('label' => 'Apellido Paterno','attr' => array('class'=>'form-control')))
            ->add('secondSurname', null,array('label' => 'Apellido Materno','attr' => array('class'=>'form-control')))
            ->add('email', EmailType::class,array('label' => 'Email','attr' => array('class'=>'form-control')))
            ->add('phone', null,array('label' => 'Telefono','attr' => array('class'=>'form-control')))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Contraseña','attr' => array('class'=>'form-control')),
                'second_options' => array('label' => 'Repita Contraseña','attr' => array('class'=>'form-control')),
            ))
            //->add('picture', null,array('label' => 'Estado'))//este corresponde al path
            /* comentados por relaciones, agregar luego
            ->add('mentor')
            ->add('other')
            ->add('student')
            */
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\User'
        ));
    }
}
