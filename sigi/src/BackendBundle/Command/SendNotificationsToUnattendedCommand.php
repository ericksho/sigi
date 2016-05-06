<?php
// src/BackendBundle/Command/SendNotificationsToUnattended.php
namespace BackendBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SendNotificationsToUnattendedCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('send:toUnattended')
            ->setDescription('Envia notificaciones por falta de accion de parte de mentores y alumnos')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $applications1 = $em->getRepository('BackendBundle:Application')->findUnattended(1);

        foreach ($applications1 as $application) {
          $this->sendEmailToUnattendedMentor($application);
        }

        $applications2 = $em->getRepository('BackendBundle:Application')->findUnattended(2);        

        foreach ($applications2 as $application) {
          $this->sendEmailToUnattendedStudent($application);
        }

        $today = date("d-M-Y h:i:s");
        $count = count($applications2)+count($applications1);
        $output->writeln($today.": Se enviaron ".count($applications1)." notificaciones a Profesores y ".count($applications2)." notificaciones a Alumnos para que tomen acciones en las postulaciones");
    }

    private function sendEmailToUnattendedMentor($application)
    {
      //enviar por email
      $today = date("d-M-Y");
      $filename = "Programacion_".$today;
      $path = $this->getContainer()->get('kernel')->getRootDir()."/../web/Programaciones/";

      $url = $this->getContainer()->getParameter('web_dir').'/application/'.$application->getId();

      $message = \Swift_Message::newInstance()
          ->setSubject('La postulación #'.$application->getId()." requiere de su atención")
          ->setFrom('gestionIPre@ing.puc.cl')
          ->setTo(array($application->getOportunityResearch()->getMentorResponsibleMentor()->getUser()->getEmail()))
          ->setBody('<html>' .
              ' <head></head>' .
              ' <body>' .
              "Hola, ".$application->getStudent()->getNameText().' ha postulado a su Oportunidad de Investigación "'.$application->getOportunityResearch()->getName() .'"'.
              ' <br> '.
              'Para revisar la postulación, haz click <a href="'.$url.'">aquí</a><br>'.
              'Atte. <br> Gestión IPre'.
              '<br><br><br>Por favor, no responda este email</body>' .
              '</html>',
              'text/html')
      ;
      $this->getContainer()->get('mailer')->send($message);
    }

    private function sendEmailToUnattendedStudent($application)
    {
      //enviar por email
      $today = date("d-M-Y");
      $filename = "Programacion_".$today;
      $path = $this->getContainer()->get('kernel')->getRootDir()."/../web/Programaciones/";

      $url = $this->getContainer()->getParameter('web_dir').'/application/'.$application->getId();

      $message = \Swift_Message::newInstance()
          ->setSubject('La postulación #'.$application->getId()." requiere de su atención")
          ->setFrom('gestionIPre@ing.puc.cl')
          ->setTo(array($application->getStudent->getUser()->getEmail()))
          ->setBody('<html>' .
              ' <head></head>' .
              ' <body>' .
              'Hola, su postulación a la Oportunidad de Investigación "'.$application->getOportunityResearch()->getName() .'" ha sido aceptada y esta esperando su confirmación'.
              ' <br> '.
              'Para revisar la postulación, haz click <a href="'.$url.'">aquí</a><br>'.
              'Atte. <br> Gestión IPre'.
              '<br><br><br>Por favor, no responda este email</body>' .
              '</html>',
              'text/html')
      ;
      $this->getContainer()->get('mailer')->send($message);
    }
}