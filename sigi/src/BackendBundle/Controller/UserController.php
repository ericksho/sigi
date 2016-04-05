<?php

namespace BackendBundle\Controller;

trait Referer {
    private function getRefererParams() {
        $request = $this->getRequest();
        $referer = $request->headers->get('referer');
        $baseUrl = $this->get('request')->getSchemeAndHttpHost();
        $lastPath = substr($referer, strpos($referer, $baseUrl) + strlen($baseUrl));
        return $this->get('router')->getMatcher()->match($lastPath);
    }
}




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
    use Referer;

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

        $student = new Student();
        $mentor = new Mentor();
        $other = new Other();

        $form = $this->createForm('BackendBundle\Form\UserType', $user,array('pass'=>'yes'));
        $form->handleRequest($request);

        //student form
        $studentForm = $this->createForm('BackendBundle\Form\StudentType', $student);
        $studentForm->handleRequest($request);

        //mentor form
        $mentorForm = $this->createForm('BackendBundle\Form\MentorType', $mentor);
        $mentorForm->handleRequest($request);

        //mentor form
        $otherForm = $this->createForm('BackendBundle\Form\OtherType', $other);
        $otherForm->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();

            // mentor
            if ($mentorForm->isSubmitted() && $mentorForm->isValid())
            {
                $em->persist($mentor);
                $user->setMentor($mentor);
            }
            
            // student
            if ($studentForm->isSubmitted() && $studentForm->isValid())
            {
                $em->persist($student);
                $user->setStudent($student);
            }

            // other
            if ($otherForm->isSubmitted() && $otherForm->isValid())
            {
                $em->persist($other);
                $user->setOther($other);
            }

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
            'student_form' => $studentForm->createView(),
            'mentor_form' => $mentorForm->createView(),
            'other_form' => $otherForm->createView(),
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

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $editButton = FALSE;

        if (($currentUser->getId() == $user->getId() || strcmp($currentUser->getRole(), "ROLE_ADMIN") == 0))
            $editButton = TRUE;

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
            'editButton' => $editButton,
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
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        /*
        if (!($currentUser->getId() == $user->getId() || strcmp($currentUser->getRole(), "ROLE_ADMIN") == 0))
        {
            $params = $this->getRefererParams();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Welcome to the Death Star, have a magical day!')
            ;

            return $this->redirectToRoute('user_edit', array('id' => $currentUser->getId()));
        }
        */

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

        if(true)//$this->get('security.token_storage')->getToken()->getUser()->getId() == $user->getid()) //si es el mismo usuario
        {
            $editForm = $this->createForm('BackendBundle\Form\UserType', $user,array('pass'=>'yes', 'edit_role'=>'no'));
            $pass = TRUE; //puede cambiar contraseña
            $edit_role = FALSE; // no puede cambiar el rol
        }
        else
        {
            $editForm = $this->createForm('BackendBundle\Form\UserType', $user,array('pass'=>'no','edit_role'=>'yes'));
            $pass = FALSE;
            $edit_role = TRUE;
        }
            

        $editForm->handleRequest($request);

        $passForm = $this->createForm('BackendBundle\Form\ChangePasswordType', $user);
        $passForm->handleRequest($request);

        //student form
        $studentForm = $this->createForm('BackendBundle\Form\StudentType', $student);
        $studentForm->handleRequest($request);

        //mentor form
        $mentorForm = $this->createForm('BackendBundle\Form\MentorType', $mentor);
        $mentorForm->handleRequest($request);

        //mentor form
        $otherForm = $this->createForm('BackendBundle\Form\OtherType', $other);
        $otherForm->handleRequest($request);


        if (($editForm->isSubmitted() && $editForm->isValid())) {
            // Encode the password (you could also do this via Doctrine listener)
            if (strlen($user->getPlainPassword()) > 0)
            {
                $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
            }

            $em = $this->getDoctrine()->getManager();  

            // mentor
            if ($mentorForm->isSubmitted() && $mentorForm->isValid())
            {
                $em->persist($mentor);
                $user->setMentor($mentor);
            }
            
            // student
            if ($studentForm->isSubmitted() && $studentForm->isValid())
            {
                $em->persist($student);
                $user->setStudent($student);
            }

            // other
            if ($otherForm->isSubmitted() && $otherForm->isValid())
            {
                $em->persist($other);
                $user->setOther($other);
            }

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
            'edit_role' => $edit_role,
            'password_form' => $passForm->createView(),
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
