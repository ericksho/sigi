<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NotificationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', 'textarea', array('label' => 'Mensaje','attr' => array('class'=>'form-control')))
            ->add('timestamp', 'datetime', array('date_widget' => 'single_text','time_widget' => 'single_text', 'attr' => array('readonly' => true), 'label' => 'Fecha y Hora', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
            //->add('readed', null,array('label' => 'Leida','attr' => array('class'=>'form-control')))//parte en false
            /*
            esto es cargado en el controlador
            ->add('sender', EntityType::class, array(
                'class' => 'BackendBundle:User',
                'choice_label' => 'username'))
                */
            ->add('reciever', EntityType::class, array(
                'class' => 'BackendBundle:User',
                'choice_label' => 'username'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Notification'
        ));
    }
}
