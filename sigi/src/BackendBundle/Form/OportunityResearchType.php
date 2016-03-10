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
use BackendBundle\Entity\Prerequisite;
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
            ->add('creationDate', 'date', array('widget' => 'single_text', 'attr' => array('readonly' => true,'class'=>'form-control'), 'label' => 'Fecha de creación'))
            ->add('description', null,array('label' => 'Descripción','attr' => array('class'=>'form-control')))
            ->add('public', ChoiceType::class,array('choices'  => array(1 => 'Publica', 2 => 'Privada'),'label' => 'Publica','attr' => array('class'=>'form-control')))
            ->add('modality', ChoiceType::class,array('choices'  => array(1 => 'Alfa numerico', 2 => 'Nota 1-7'),'label' => 'Modalidad','attr' => array('class'=>'form-control')))
            ->add('publish', null,array('label' => 'Publicada','attr' => array('class'=>'form-control','checked'=>true)))
            ->add('vacants','integer',array('label' => 'Vacantes','attr' => array('class'=>'form-control','min'=>1,'max' => 10),'scale'=>0))
            ->add('oportunityKeywords', EntityType::class, array(
                'label' => 'Palabras claves',
                'required' => false,
                'placeholder' => 'Keywords relacionadas',
                'class' => 'BackendBundle:Keyword',
                'multiple' => true,
                'attr' => array('class'=>'js-example-tokenizer'),
                'choice_label' => 'keyword',))

            ->add('prerequisites', EntityType::class, array(
                'label' => 'Prerequisitos (Siglas)',
                'required' => false,
                'placeholder' => 'Agregue siglas de prerequisito',
                'class' => 'BackendBundle:Prerequisite',
                'multiple' => true,
                'attr' => array('class'=>'js-tokenizer'),
                'choice_label' => 'courseNumber',))

            ->add('department', EntityType::class, array(
                'label' => 'Departamento',
                'required' => false,
                'placeholder' => 'Agregue siglas de prerequisito',
                'class' => 'BackendBundle:Department',
                'multiple' => false,
                'group_by' => 'faculty.name',
                'attr' => array('class'=>'js-basic-single'),
                'choice_label' => 'name',))

            /* comentados por relaciones, agregar luego
            ->add('research')
            */
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $oportunityResearch = $event->getData();
            $form = $event->getForm();

            // check if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            if (!$oportunityResearch || null === $oportunityResearch->getCreationDate()) {
                $form->add('creationDate', 'date', array('widget' => 'single_text', 'attr' => array('readonly' => true,'class'=>'form-control'), 'label' => 'Fecha de creación', 'data' => (new \DateTime())));
            }
        });

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

                if (isset($data['prerequisites']))
                {
                    $prerequisites = $data['prerequisites'];
    
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
    
                    $data['prerequisites'] = $prerequisites;
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
