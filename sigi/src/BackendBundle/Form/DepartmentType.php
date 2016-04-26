<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DepartmentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,array('label' => 'Nombre','attr' => array('class'=>'form-control')))
            ->add('initialsCode', null,array('label' => 'Iniciales Sigla','attr' => array('class'=>'form-control')))
            ->add('faculty', EntityType::class, array(
                'label' => 'Facultad/Escuela',
                'required' => false,
                'placeholder' => 'Escoga la facultad',
                'class' => 'BackendBundle:Faculty',
                'multiple' => false,
                'attr' => array('class'=>'js-basic-single'),
                'choice_label' => 'name',
                'required' => true))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Department'
        ));
    }
}
