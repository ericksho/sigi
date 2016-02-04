<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MentorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$role = $options['role'];

        $builder
            ->add('uc')
            //->add('picture', null,array('label' => 'Estado'))//este corresponde al path
            /* comentados por relaciones, agregar luego
            ->add('mentor')

            ->add('other')
            ->add('student')

            */
        ;
        if (false) {
            $builder->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Contraseña','attr' => array('class'=>'form-control')),
                'second_options' => array('label' => 'Repita Contraseña','attr' => array('class'=>'form-control')),
            ));
        }
    }


    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\User',
            'validation_groups' => array('edit'),
            'role' => null
        ));
    }
}
