<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ApplicationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $studentId = $options['studentId'];
        $oportunityId = $options['oportunityId'];
        $choices_array = $options['choices_array'];

        $builder
            ->add('state', null,array('label' => 'Estado','attr' => array('class'=>'form-control')))
            ->add('state', ChoiceType::class, array(
                'label' => 'Estado',
                'attr' => array('class'=>'form-control'),
                'choices'  => $choices_array,
                // *this line is important*
                'choices_as_values' => true,
            ))
            ->add('applicationDate', 'date', array('widget' => 'single_text', 'attr' => array('readonly' => true,'class'=>'form-control'), 'label' => 'Fecha de aplicación', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
            ->add('lastUpdateDate', 'date', array('widget' => 'single_text', 'attr' => array('readonly' => true,'class'=>'form-control'), 'label' => 'Ultima actualización', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
            
            ->add('student', HiddenType::class, array('data' => $studentId))
            
            ->add('oportunityResearch', HiddenType::class, array('data' => $oportunityId))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Application',
            'studentId' => null,
            'oportunityId' => null,
            'choices_array' => null, 
        ));
    }
}
