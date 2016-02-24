<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    "Ramo (prerequisito)" => 1,
                    "Carrera/area"  => 2,
                    "Creditos" => 3,
                    "indefinido" => 0),
                'choices_as_values' => true,
                'label' => 'Tipo','attr' => array('class'=>'form-control')))
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
