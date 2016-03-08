<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FacultyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,array('label' => 'Nombre','attr' => array('class'=>'form-control')))
            /*
            ->add('departments', EntityType::class, array(
                'label' => 'Departamentos',
                'required' => false,
                'placeholder' => 'Seleccione departamentos',
                'class' => 'BackendBundle:Department',
                'multiple' => true,
                'attr' => array('class'=>'js-tokenizer'),
                'choice_label' => 'name',))
                */
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Faculty'
        ));
    }
}
