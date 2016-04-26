<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EmailListType extends AbstractType
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
                'Email Dara' => 'Email Dara')
                ))
            ->add('email',null,array('label' => 'Dirección de correo','attr' => array('class'=>'form-control','value'=>"evsvec@uc.cl")))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\EmailList'
        ));
    }
}
