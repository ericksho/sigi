<?php

namespace BackendBundle\Form;

use Doctrine\ORM\EntityRepository;
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
        $recieverId = $options['recieverId'];

        $builder
            ->add('message', 'textarea', array('label' => 'Mensaje','attr' => array('class'=>'form-control')))
            ->add('timestamp', 'datetime', array('date_widget' => 'single_text','time_widget' => 'single_text', 'attr' => array('readonly' => true), 'label' => 'Fecha y Hora', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
            
            ->add('reciever', EntityType::class, array(
                'label' => 'Para:',
                'attr' => array('class'=>'form-control'),
                'class' => 'BackendBundle:User',
                'choice_label' => 'username'))
        ;

        if (!is_null($recieverId)) 
        {
            $builder->add('reciever', EntityType::class, array(
                'label' => 'Para:',
                'attr' => array('class'=>'form-control'),
                'class' => 'BackendBundle:User',
                'choice_label' => 'username',
                'query_builder' => function (EntityRepository $er)  use ( $recieverId ) {return $er
                    ->createQueryBuilder('r')
                    ->where("r.id = :id")
                    ->setParameter('id', $recieverId);}));
        }
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Notification',
            'recieverId' => null,
        ));
    }
}
