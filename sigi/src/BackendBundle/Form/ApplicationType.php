<?php

namespace BackendBundle\Form;

use Doctrine\ORM\EntityRepository;
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
        ->add('student', EntityType::class, array(
                'label' => 'Alumno',
                'attr' => array('class'=>'form-control'),
                'class' => 'BackendBundle:Student',
                'choice_label' => 'getNameText',
                'query_builder' => function (EntityRepository $er)  use ( $studentId ) {return $er
                    ->createQueryBuilder('s')
                    ->where("s.id = :id")
                    ->setParameter('id', $studentId);},
            ))
        ->add('oportunityResearch', EntityType::class, array(
                'label' => 'Oportunidad de Investigación',
                'attr' => array('class'=>'form-control'),
                'class' => 'BackendBundle:OportunityResearch',
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er)  use ( $oportunityId ) {return $er
                    ->createQueryBuilder('o')
                    ->where("o.id = :id")
                    ->setParameter('id', $oportunityId);},
            ))

            ->add('state', ChoiceType::class, array(
                'label' => 'Estado',
                'attr' => array('class'=>'form-control'),
                'choices'  => $choices_array,
                // *this line is important*
                'choices_as_values' => true,
            ))
            ->add('applicationDate', 'date', array('widget' => 'single_text', 'attr' => array('readonly' => true,'class'=>'form-control'), 'label' => 'Fecha de Postulación', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
            ->add('lastUpdateDate', 'datetime', array('widget' => 'single_text', 'format' => 'dd/MM/yyyy HH:mm:ss','attr' => array('readonly' => true,'class'=>'form-control'), 'label' => 'Ultima actualización', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
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
