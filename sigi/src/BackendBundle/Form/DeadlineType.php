<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DeadlineType extends AbstractType
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
                'fin primer semestre' => 'fin primer semestre',
                'fin segundo semestre' => 'fin segundo semestre')
                ))
            ->add('day','integer',array('label' => 'Dia','attr' => array('class'=>'form-control','min'=>1,'max' => 31),'scale'=>0))
            ->add('month', ChoiceType::class,array('label' => 'Mes','attr' => array('class'=>'form-control'),
                'choices'  => array(
                1 => 'Enero',
                2 => 'Febrero',
                3 => 'Marzo',
                4 => 'Abril',
                5 => 'Mayo',
                6 => 'Junio',
                7 => 'Julio',
                8 => 'Agosto',
                9 => 'Septiembre',
                10 => 'Octubre',
                11 => 'Noviembre',
                12 => 'Diciembre')
                ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Deadline'
        ));
    }
}
