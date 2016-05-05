<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TimeLimitType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', ChoiceType::class,array('label' => 'Nombre','attr' => array('class'=>'form-control'),
                'choices'  => array(
                'Plazo para que el mentor acepte/rechaze la postulación' => 'Plazo para que el mentor acepte/rechaze la postulación',
                'Plazo para que el alumno acepte/rechaze la postulación' => 'Plazo para que el alumno acepte/rechaze la postulación')
                ))
            ->add('days','integer',array('label' => 'Dias','attr' => array('class'=>'form-control','min'=>1),'scale'=>0))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\TimeLimit'
        ));
    }
}
