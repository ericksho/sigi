	<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\Restorer;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SecurityController extends Controller
{
	/**
     * @Route("/login", name="login_route")
     */
    public function loginAction(Request $request)
	{
	    $authenticationUtils = $this->get('security.authentication_utils');

	    // get the login error if there is one
	    $error = $authenticationUtils->getLastAuthenticationError();

	    // last username entered by the user
	    $lastUsername = $authenticationUtils->getLastUsername();

	    return $this->render(
	        'security/login.html.twig',
	        array(
	            // last username entered by the user
	            'last_username' => $lastUsername,
	            'error'         => $error,
	        )
	    );
	}

	/**
     * @Route("/resetPassword", name="reset_password_route")
     * @Method({"GET", "POST"})
     */
    public function resetPasswordAction(Request $request)
	{
	    $em = $this->getDoctrine()->getManager();

	    $token = $request->query->get('token');

	    $restorer = $em->getRepository('BackendBundle:Restorer')->findOneByAuth(md5($token));

	    if(is_null($restorer))//we finished and redirect, no output
	    {
	    	return $this->redirectToRoute('backend_homepage');
	    }

	    $user = $restorer->getUser();

	    $resetForm = $this->createFormBuilder($user)
	    	->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Contraseña','attr' => array('disabled' => false, 'class'=>'form-control')),
                'second_options' => array('label' => 'Repita Contraseña','attr' => array('disabled' => false, 'class'=>'form-control')),
                ))
            ->getForm();
        $form = $request->get('form');

	    if (!is_null($form) && $form["plainPassword"]["first"] == $form["plainPassword"]["second"]) 
	    {
	    	$password = $this->get('security.password_encoder')
                ->encodePassword($user, $form["plainPassword"]["first"]);
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->remove($restorer);
            $em->flush();

            return $this->redirectToRoute('notification_index');
	    }

	    return $this->render(
	        'security/resetPassword.html.twig',
	        array(
	        	'reset_form' => $resetForm->createView(),
	        )
	    );
	}

	/**
     * @Route("/lostPassword", name="lost_password_route")
     */
    public function lostPasswordAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

	    $reset = false;
	    if($request->request->get('reset') == "true")
	    	$reset = true;

	    if($reset)
	    {
	    	$user = $em->getRepository('BackendBundle:User')->findOneByEmail($request->request->get('email'));

	    	if(!is_null($user))
	    	{
	    		$rb = uniqid(rand(), true);
	    		$random = md5($user->getEmail().$rb);

	    		//guardar en la base de datos
	    		$restorer = $em->getRepository('BackendBundle:Restorer')->findOneByUser($user);
	    		if(is_null($restorer))
	    		{
	    			$restorer = new Restorer();
	    		}

	    		$restorer->setUser($user);
	    		$restorer->setTime(new \DateTime());
	    		$restorer->setAuth(md5($random));
	    		$em->persist($restorer);
	    		$em->flush();

	    		$baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
	    		$url = $baseurl.'/resetPassword?token='.$random;

	    		$message = \Swift_Message::newInstance()
					->setSubject('Recuperación de contraseña')
					->setFrom('gestionIPre@ing.puc.cl')
					->setTo(array($user->getEmail()))
					->setBody('<html>' .
					    ' <head></head>' .
					    ' <body>' .
					    ' Hola, usa este link para recuperar tu contraseña: ' .
					    '<a href="'.$url.'">'.$url.'</a></br>'.
					    ' Si no pediste recuperar contraseña omite este email. (No responda este email)</body>' .
					    '</html>',
					    'text/html')
				;
				$this->get('mailer')->send($message);
	    	}
	    }


	    return $this->render(
	        'security/lostPassword.html.twig',	
	        array(
	            // last username entered by the user
	            'reset' => $reset,
	        )
	    );
	}

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }
}
