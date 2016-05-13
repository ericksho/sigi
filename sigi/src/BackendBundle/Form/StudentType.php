<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class StudentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uc',null,array('label' => 'Es UC/Is UC', 'attr' => array('class'=>'form-control')))
            ->add('department', EntityType::class, array(
                'label' => 'Facultad/Escuela/Departamento / Faculty/School/Department',
                'required' => false,
                'class' => 'BackendBundle:Department',
                'multiple' => false,
                'group_by' => 'faculty.name',
                'attr' => array('class'=>'js-basic-single'),
                'choice_label' => 'name',))
        ;
    }


    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Student',
        ));
    }
}
