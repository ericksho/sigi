<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', null,array('label' => 'Sigla'))
            ->add('section', null,array('label' => 'Sección'))
            ->add('creationDate', 'date', array('widget' => 'single_text', 'attr' => array('readonly' => true), 'label' => 'Fecha de creación', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
            /* comentados por relaciones, agregar luego
            ->add('mainMentor')
            ->add('secondaryMentor')
            ->add('thertiaryMentor')
            ->add('student')
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
            'data_class' => 'BackendBundle\Entity\Research'
        ));
    }
}
