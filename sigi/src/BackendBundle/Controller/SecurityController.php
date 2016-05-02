<?php

namespace BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
	    		$random = base64_encode($user->getEmail()."///".random_bytes(10));

	    		//guardar en la base de datos

	    		$message = \Swift_Message::newInstance()
					->setSubject('Recuperación de contraseña')
					->setFrom('gestionIPre@ing.puc.cl')
					->setTo(array($user->getEmail()))
					->setBody("Hola, perdiste tu contraseña, el token de autenticidad es".$random.", pavo (no responda este email)")
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
