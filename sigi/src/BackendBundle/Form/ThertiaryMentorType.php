<?php

namespace BackendBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ThertiaryMentorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('thertiaryMentor', EntityType::class, array(
                'required' => false,
                'placeholder' => 'Seleccione al Mentor Terciario',
                'class' => 'BackendBundle:Mentor',
                'query_builder' => function (EntityRepository $er) {return $er
                    ->createQueryBuilder('m')
                    ->join('m.user', 'u')
                    ->where("u.role = 'ROLE_MENTOR'")
                    ->orderBy('m.id', 'ASC');},
                'choice_label' => 'getShowName',))
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
