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
        $current_id = 1;

        $builder
            ->add('name', null,array('label' => 'Nombre','attr' => array('class'=>'form-control left-column-form')))
            ->add('english_name', null,array('label' => 'Name (Si lo deja en blanco se hará una traducción automatica con Yandex)', 'required' => false,'attr' => array('class'=>'form-control left-column-form')))
            ->add('description', null,array('label' => 'Descripción','attr' => array('class'=>'form-control left-column-form')))
            ->add('english_description', null,array('label' => 'Description (Si lo deja en blanco se hará una traducción automatica con Yandex)', 'required' => false,'attr' => array('class'=>'form-control left-column-form')))
            ->add('oportunityKeywords', EntityType::class, array(
                'label' => 'Palabras claves',
                'required' => false,
                'placeholder' => 'Keywords relacionadas',
                'class' => 'BackendBundle:Keyword',
                'multiple' => true,
                'attr' => array('class'=>'js-example-tokenizer left-column-form'),
                'choice_label' => 'keyword',))
            ->add('prerequisites', EntityType::class, array(
                'label' => 'Prerequisitos (Siglas)',
                'required' => false,
                'placeholder' => 'Agregue siglas de prerequisito',
                'class' => 'BackendBundle:Prerequisite',
                'multiple' => true,
                'attr' => array('class'=>'js-tokenizer left-column-form'),
                'choice_label' => 'courseNumber',))
            ->add('public', ChoiceType::class,array('choices'  => array(1 => 'Publica', 2 => 'Privada'),'label' => 'Publica','attr' => array('class'=>'form-control right-column-form')))
            ->add('modality', ChoiceType::class,array('choices'  => array(1 => 'Nota 1-7', 2 => 'Alfa numerico'),'label' => 'Método de evaluación','attr' => array('class'=>'form-control right-column-form')))
            ->add('publish', null,array('label' => 'Publicada','attr' => array('class'=>'form-control right-column-form','checked'=>true)))
            ->add('vacants','integer',array('label' => 'Vacantes','attr' => array('class'=>'form-control right-column-form','min'=>1,'max' => 10,),'scale'=>0))
            ->add('credits','choice',array('label' => 'Créditos','choices'  => array(5 => '5 cr.',10 => '10 cr.', 20 => '20 cr.'),'attr' => array('class'=>'form-control right-column-form',)))
            ->add('department', EntityType::class, array(
                'label' => 'Facultad/Escuela/Departamento',
                'required' => false,
                'placeholder' => 'Agregue siglas de prerequisito',
                'class' => 'BackendBundle:Department',
                'multiple' => false,
                'group_by' => 'faculty.name',
                'attr' => array('class'=>'js-basic-single left-column-form'),
                'choice_label' => 'name',))
            ->add('responsibleMentor','choice',array('label' => 'Mentor Responsable','choices'  => array(1 => 'Yo',2 => 'Segundo Mentor', 3=>'Tercer Mentor'),'attr' => array('class'=>'form-control left-column-form',)))
            ->add('secondaryMentor', EntityType::class, array(
                'label' => 'Agregar un segundo Mentor',
                'attr' => array('class'=>'js-basic-single-secondaryMentor left-column-form'),
                'required' => false,
                'placeholder' => 'Seleccione al Mentor Secundario',
                'class' => 'BackendBundle:Mentor',
                'query_builder' => function (EntityRepository $er)  use ( $current_id ) {return $er
                    ->createQueryBuilder('m')
                    ->join('m.user', 'u')
                    ->where("u.role = 'ROLE_MENTOR'")
                    ->andWhere('u.id <> :id')
                    ->setParameter('id', $current_id)
                    ->orderBy('m.id', 'ASC');},
                'choice_label' => 'getShowName',))
            ->add('thertiaryMentor', EntityType::class, array(
                'label' => 'Agregar un tercer Mentor',
                'attr' => array('class'=>'js-basic-single-thertiaryMentor left-column-form', 'id'=>'list'),
                'required' => false,
                'placeholder' => 'Seleccione al Mentor Terciario',
                'class' => 'BackendBundle:Mentor',
                'query_builder' => function (EntityRepository $er)  use ( $current_id ) {return $er
                    ->createQueryBuilder('m')
                    ->join('m.user', 'u')
                    ->where("u.role = 'ROLE_MENTOR'")
                    ->andWhere('u.id <> :id')
                    ->setParameter('id', $current_id)
                    ->orderBy('m.id', 'ASC');},
                'choice_label' => 'getShowName',))
            ->add('creationDate', 'date', array('widget' => 'single_text', 'attr' => array('readonly' => true,'class'=>'form-control right-column-form'), 'label' => 'Fecha de creación'))

            ->add('cmd', null,array('label' => 'Es CMD','attr' => array('class'=>'form-control right-column-form','checked'=>false)))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $oportunityResearch = $event->getData();
            $form = $event->getForm();

            // check if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            if (!$oportunityResearch || null === $oportunityResearch->getCreationDate()) {
                $form->add('creationDate', 'date', array('widget' => 'single_text', 'attr' => array('readonly' => true,'class'=>'form-control right-column-form'), 'label' => 'Fecha de creación', 'data' => (new \DateTime())));
            }
            if (!$oportunityResearch || null === $oportunityResearch->getVacants()) {
                $form->add('vacants','integer',array('label' => 'Vacantes','attr' => array('class'=>'form-control right-column-form','min'=>1,'max' => 10, 'value' => 1,),'scale'=>0));
            }
        });

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $data = $event->getData();                

                //////////// revisamos si hay keywords que agregar 
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

                //////////// revisamos si hay prerequisitos que agregar 
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
            'data_class' => 'BackendBundle\Entity\OportunityResearch',
            'department' => null        
        ));
    }
}
