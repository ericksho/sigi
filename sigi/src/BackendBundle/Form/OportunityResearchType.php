<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OportunityResearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creationDate', 'datetime', array('date_widget' => 'single_text','time_widget' => 'single_text', 'attr' => array('readonly' => true), 'label' => 'Fecha de creación', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
            ->add('name', null,array('label' => 'Nombre'))
            ->add('description', null,array('label' => 'Descripción'))
            ->add('public', null,array('label' => 'Publico'))
            ->add('modality', null,array('label' => 'Modalidad'))
            ->add('publish', null,array('label' => 'Publicada'))
            /* comentados por relaciones, agregar luego
            ->add('research')
            ->add('mainMentor')
            ->add('secondaryMentor')
            ->add('thertiaryMentor')
            */
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\OportunityResearch'
        ));
    }
}
