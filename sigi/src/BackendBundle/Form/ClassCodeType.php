<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassCodeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('initialsCode',null,array('label' => 'Iniciales de la Sigla','attr' => array('class'=>'form-control','placeholder'=>"ejemplo: IIC")))
            ->add('numbersCode',null,array('label' => 'Parte Numerica de la Sigla','attr' => array('class'=>'form-control','placeholder'=>"ejemplo: 1062", "min"=>"1","max"=>"9999")))
            ->add('credits','choice',array('label' => 'Créditos','choices'  => array(5 => '5 cr.',10 => '10 cr.'),'attr' => array('class'=>'form-control',)))
            ->add('name',null,array('label' => 'Nombre','attr' => array('class'=>'form-control','placeholder'=>"ejemplo: Trabajo Personal Dirigido")))
            ->add('mentorIng',null,array('label' => 'Es mentor de Ingenieria','attr' => array('class'=>'form-control')))
            ->add('studentIng',null,array('label' => 'Es estudiante de Ingenieria','attr' => array('class'=>'form-control')))
            ->add('cmd',null,array('label' => 'es CMD?','attr' => array('class'=>'form-control')))
            ->add('time',null,array('label' => 'Vez','attr' => array('class'=>'form-control','placeholder'=>"1 para primera vez que el alumno toma IPRE, 2 para segunda, etc", "min"=>"1","max"=>"6")))
            ->add('graded','choice',array('label' => 'Evaluado con','choices'  => array(true => 'Nota de 1 a 7',false => 'Alfanumerico'),'attr' => array('class'=>'form-control')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\ClassCode'
        ));
    }
}
