<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userType', null,array('label' => 'Tipo de usuario'))
            ->add('userName', null,array('label' => 'Nombre de usuario'))
            ->add('rut', null,array('label' => 'Rut'))
            ->add('name', null,array('label' => 'Nombre'))
            ->add('middleName', null,array('label' => 'Segundo Nombre'))
            ->add('lastName', null,array('label' => 'Apellido Paterno'))
            ->add('secondSurname', null,array('label' => 'Apellido Materno'))
            ->add('email', null,array('label' => 'Email'))
            ->add('phone', null,array('label' => 'Telefono'))
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
