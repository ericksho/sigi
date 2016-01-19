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
            ->add('name', null,array('label' => 'Nombre','attr' => array('class'=>'form-control')))
            ->add('creationDate', 'datetime', array('date_widget' => 'single_text','time_widget' => 'single_text', 'attr' => array('readonly' => true), 'label' => 'Fecha de creación', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
            ->add('description', null,array('label' => 'Descripción','attr' => array('class'=>'form-control')))
            ->add('public', null,array('label' => 'Publico','attr' => array('class'=>'form-control')))
            ->add('modality', null,array('label' => 'Modalidad','attr' => array('class'=>'form-control')))
            ->add('publish', null,array('label' => 'Publicada','attr' => array('class'=>'form-control')))
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
