<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('state', null,array('label' => 'Estado'))
            ->add('applicationDate', 'datetime', array('date_widget' => 'single_text','time_widget' => 'single_text', 'attr' => array('readonly' => true), 'label' => 'Fecha de aplicación', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
            ->add('lastUpdateDate', 'datetime', array('date_widget' => 'single_text','time_widget' => 'single_text', 'attr' => array('readonly' => true), 'label' => 'Ultima actualización', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
            /* comentados por relaciones, agregar luego
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
            'data_class' => 'BackendBundle\Entity\Application'
        ));
    }
}
