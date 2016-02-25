<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use BackendBundle\Entity\Keyword;
use BackendBundle\Entity\Prerequisite;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
class ResearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', null,array('label' => 'Sigla','attr' => array('class'=>'form-control')))
            ->add('section', null,array('label' => 'Sección','attr' => array('class'=>'form-control')))
            ->add('creationDate', 'date', array('widget' => 'single_text', 'attr' => array('readonly' => true,'class'=>'form-control'), 'label' => 'Fecha de creación', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente

            ->add('oportunityResearch', EntityType::class, array(
                'required' => false,
                'placeholder' => 'Selector Temporal***',
                'class' => 'BackendBundle:OportunityResearch',
                'choice_label' => 'description',))

            ->add('nameOP', null,array('label' => 'Nombre de la oportunidad','attr' => array('class'=>'form-control')))
            ->add('creationDateOP', 'date', array('widget' => 'choice', 'attr' => array('class'=>'form-control'), 'label' => 'Fecha de creación de la oportunidad', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
            ->add('descriptionOP', null,array('label' => 'Descripción de la oportunidad','attr' => array('class'=>'form-control')))
            ->add('modalityOP', ChoiceType::class,array('choices'  => array(1 => 'Alfa numerico', 2 => 'Nota 1-7'),'label' => 'Modalidad','attr' => array('class'=>'form-control')))
            ->add('oportunityKeywordsOP', EntityType::class, array(
                'label' => 'Palabras claves',
                'required' => false,
                'placeholder' => 'Keywords relacionadas',
                'class' => 'BackendBundle:Keyword',
                'multiple' => true,
                'attr' => array('class'=>'js-example-tokenizer'),
                'choice_label' => 'keyword',))

            ->add('prerequisitesOP', EntityType::class, array(
                'label' => 'Prerequisitos (Siglas)',
                'required' => false,
                'placeholder' => 'Agregue siglas de prerequisito',
                'class' => 'BackendBundle:Prerequisite',
                'multiple' => true,
                'attr' => array('class'=>'js-tokenizer'),
                'choice_label' => 'courseNumber',))





            /* comentados por relaciones, agregar luego
            ->add('mainMentor')
            ->add('secondaryMentor')
            ->add('thertiaryMentor')
            ->add('student')
            */
        ;

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $data = $event->getData();

                if (isset($data['oportunityKeywordsOP']))
                {
                    $keywords = $data['oportunityKeywordsOP'];
    
                    $s = " ";         
    
                    foreach($keywords as $keywordId)
                    {
                        
                        if(!is_numeric($keywordId))
                        {
                            $keyword = new Keyword();
                            $keyword->setKeyword($keywordId);
    
                            $em = $this->em;
                            $em->persist($keyword);
                            $em->flush();
    
                            $keyId = array_search($keywordId, $keywords); // returns the first key whose value is 'green'
                            $keywords[$keyId] = $keyword->getId(); // replace 'green' with 'apple'
                        }
                    }
    
                    $data['oportunityKeywordsOP'] = $keywords;
                    $event->setData($data);
                }

                if (isset($data['prerequisitesOP']))
                {
                    $prerequisites = $data['prerequisitesOP'];
    
                    $s = " ";         
    
                    foreach($prerequisites as $prerequisiteId)
                    {
                        
                        if(!is_numeric($prerequisiteId))
                        {
                            $prerequisite = new Prerequisite();
                            $prerequisite->setCourseNumber($prerequisiteId);
    
                            $em = $this->em;
                            $em->persist($prerequisite);
                            $em->flush();
    
                            $keyId = array_search($prerequisiteId, $prerequisites); // returns the first key whose value is 'green'
                            $prerequisites[$keyId] = $prerequisite->getId(); // replace 'green' with 'apple'
                        }
                    }
    
                    $data['prerequisitesOP'] = $prerequisites;
                    $event->setData($data);
                }
            }
        );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Research'
        ));
    }
}
