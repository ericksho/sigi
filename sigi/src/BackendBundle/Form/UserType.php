<?php

namespace BackendBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
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
        $role = $options['role'];
        $pass = $options['pass'];
        $edit_role = $options['edit_role'];

        $builder
            ->add('role', ChoiceType::class, array('label' => "Rol",'attr' => array('class'=>'form-control',"onchange" => "collapseJS();"),
                'choices' => array('Administrador' => 'ROLE_ADMIN', 'Estudiante' => 'ROLE_STUDENT', 'Mentor' => 'ROLE_MENTOR', 'Otro' => 'ROLE_OTHER'),
                // always include this
                'choices_as_values' => true))
            ->add('username', null,array('label' => 'Nombre de usuario/Username','attr' => array('class'=>'form-control')))
            ->add('rut', null,array('label' => 'Rut', 'required' => false,'attr' => array('class'=>'form-control')))
            ->add('passportNumber', null,array('label' => 'Numero de pasaporte/Passport Number', 'required' => false,'attr' => array('class'=>'form-control')))
            ->add('name', null,array('label' => 'Nombre/Name','attr' => array('class'=>'form-control')))
            ->add('middleName', null,array('label' => 'Segundo Nombre/Middle Name','attr' => array('class'=>'form-control')))
            ->add('lastName', null,array('label' => 'Apellido Paterno/Last Name','attr' => array('class'=>'form-control')))
            ->add('secondSurname', null,array('label' => 'Apellido Materno/Second Surname','attr' => array('class'=>'form-control')))
            ->add('email', EmailType::class,array('label' => 'Email','attr' => array('class'=>'form-control')))
            ->add('phone', null,array('label' => 'Telefono/Phone Number','attr' => array('class'=>'form-control')))

        ;
        if (false){
            $builder->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Contraseña/Password','attr' => array('disabled' => false, 'class'=>'form-control')),
                'second_options' => array('label' => 'Repita Contraseña/Repeat Password','attr' => array('disabled' => false, 'class'=>'form-control')),
            ));
        }

        if($edit_role == 'no')
        {
            $builder->add('role', HiddenType::class)
            ;
        }

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $data = $event->getData();                

                //////////// revisamos si hay keywords que agregar 
                if (!isset($data['rut']))
                {   
                    $em = $this->em;
                    $nextSyntheticRut = $em->getRepository('BackendBundle:User')->getNextSyntheticRut();
                    $data['rut'] = $nextSyntheticRut;
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
            'data_class' => 'BackendBundle\Entity\User',
            'validation_groups' => array('edit'),
            'role' => null,
            'pass' => null,
            'edit_role' => false,
        ));
    }
}
