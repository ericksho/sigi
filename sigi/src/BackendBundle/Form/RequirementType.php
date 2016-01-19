<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequirementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', null,array('label' => 'Descripción','attr' => array('class'=>'form-control')))
            ->add('type', null,array('label' => 'Tipo','attr' => array('class'=>'form-control')))
            ->add('function', null,array('label' => 'Funcion','attr' => array('class'=>'form-control')))
            /* comentados por relaciones, agregar luego
            ->add('oportunityResearch')
            */
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Requirement'
        ));
    }
}
