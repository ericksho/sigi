<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\User;
use BackendBundle\Form\UserType;
use BackendBundle\Entity\Student;
use BackendBundle\Form\StudentType;
use BackendBundle\Entity\Mentor;
use BackendBundle\Form\MentorType;
use BackendBundle\Entity\Other;
use BackendBundle\Form\OtherType;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('BackendBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('BackendBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        //si el usuario tiene student
        if ($user->getStudent())
            $student = $user->getStudent();
        else // si no tiene student
            $student = new Student();

        //vemos si tiene o no mentor
        if ($user->getMentor())
            $mentor = $user->getMentor();
        else
            $mentor = new Mentor();

        //vemos si tiene o no other
        if ($user->getOther())
            $other = $user->getOther();
        else
            $other = new Other();

        $deleteForm = $this->createDeleteForm($user);
        if(is_null($this->get('security.token_storage')->getToken()->getUser()))
        {
            $editForm = $this->createForm('BackendBundle\Form\UserType', $user,array('role'=>$this->get('security.token_storage')->getToken()->getUser()->getRole()));
        }
        else
        {
            $editForm = $this->createForm('BackendBundle\Form\UserType', $user);
        }
        $editForm->handleRequest($request);

        //student form
        $studentForm = $this->createForm('BackendBundle\Form\StudentType', $student);
        $studentForm->handleRequest($request);

        //mentor form
        $mentorForm = $this->createForm('BackendBundle\Form\MentorType', $mentor);
        $mentorForm->handleRequest($request);

        //mentor form
        $otherForm = $this->createForm('BackendBundle\Form\OtherType', $other);
        $otherForm->handleRequest($request);


        if (($editForm->isSubmitted() && $editForm->isValid()) 
            && ($studentForm->isSubmitted() && $studentForm->isValid())
            && ($mentorForm->isSubmitted() && $mentorForm->isValid())
            && ($otherForm->isSubmitted() && $otherForm->isValid())) {
            // Encode the password (you could also do this via Doctrine listener)

            $em = $this->getDoctrine()->getManager();  

            // mentor
            $em->persist($mentor);
            $user->setMentor($mentor);
            
            // student
            $em->persist($student);
            $user->setStudent($student);

            // other
            $em->persist($other);
            $user->setOther($other);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'student' => $student,
            'edit_form' => $editForm->createView(),
            'student_form' => $studentForm->createView(),
            'mentor_form' => $mentorForm->createView(),
            'other_form' => $otherForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
