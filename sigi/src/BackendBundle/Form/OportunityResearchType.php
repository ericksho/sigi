<?php

namespace BackendBundle\Form;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use BackendBundle\Entity\Keyword;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class OportunityResearchType extends AbstractType
{

    protected $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', null,array('label' => 'Nombre','attr' => array('class'=>'form-control')))
            ->add('creationDate', 'datetime', array('date_widget' => 'single_text','time_widget' => 'single_text', 'attr' => array('readonly' => true), 'label' => 'Fecha de creación', 'data' => (new \DateTime())))//fecha debe ser creada automaticamente
            ->add('description', null,array('label' => 'Descripción','attr' => array('class'=>'form-control')))
            ->add('public', ChoiceType::class,array('choices'  => array(1 => 'Publica', 2 => 'Privada'),'label' => 'Publica','attr' => array('class'=>'form-control')))
            ->add('modality', ChoiceType::class,array('choices'  => array(1 => 'Alfa numerico', 2 => 'Nota 1-7'),'label' => 'Modalidad','attr' => array('class'=>'form-control')))
            ->add('publish', null,array('label' => 'Publicada','attr' => array('class'=>'form-control')))
            ->add('oportunityKeywords', EntityType::class, array(
                'label' => 'Palabras claves',
                'required' => false,
                'placeholder' => 'Keywords relacionadas',
                'class' => 'BackendBundle:Keyword',
                'multiple' => true,
                'attr' => array('class'=>'js-example-tokenizer'),
                'choice_label' => 'keyword',))

            /* comentados por relaciones, agregar luego
            ->add('research')
            */
        ;

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $data = $event->getData();

                if (isset($data['oportunityKeywords']))
                {
                    $keywords = $data['oportunityKeywords'];
    
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
    
                    $data['oportunityKeywords'] = $keywords;
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
            'data_class' => 'BackendBundle\Entity\OportunityResearch'
        ));
    }
}
