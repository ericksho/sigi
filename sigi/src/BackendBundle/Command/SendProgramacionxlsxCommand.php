<?php
// src/BackendBundle/Command/GreetCommand.php
namespace BackendBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SendProgramacionxlsxCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('send:programacion')
            ->setDescription('Envia la programacion de cursos los 15 de cada mes')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //generacion xlsx
        $em = $this->getContainer()->get('doctrine')->getManager();
        $emailDara = $em->getRepository('BackendBundle:EmailList')->findOneByName('Email Dara');

        $researches = $em->getRepository('BackendBundle:Research')->programationUnsendedToDara();
        $date = date("d-M-Y h:i:s");

        if (count($researches) == 0)
        {
          $output->writeln($date.": No hay programaciones para este periodo");
        }
        else
        {
          try
          { 
            $this->generateProgramacionXLSX($researches);
          }
          catch(Exception $e)
          {
              $output->writeln($e->getMessage());
              return $e->getMessage();
          } 
          
          $output->writeln($date.": Programacion generada");

          //enviar por email
          $today = date("d-M-Y");
          $filename = "Programacion_".$today;
          $path = $this->getContainer()->get('kernel')->getRootDir()."/../web/Programaciones/";

          $message = \Swift_Message::newInstance()
              ->setSubject('Programación de Cursos IPre')
              ->setFrom('gestionIPre@ing.puc.cl')
              ->setTo(array($emailDara->getEmail()))
              ->setBody("Hola, adjuntamos la programación de cursos de este mes, saludos, \nGestión IPre")
              ->attach(\Swift_Attachment::fromPath($path.$filename.".xlsx"))
          ;
          $this->getContainer()->get('mailer')->send($message);
          $output->writeln($date.": Programacion enviada");

          // seteamos los estados como programacion envada a dara
          foreach ($researches as $research) {
            $research->getApplication()->setState(4);
            $em->flush();
          }
        }
    }
    //Hardcoded report :S
    private function generateProgramacionXLSX($dataArray)
    {
      $em = $this->getContainer()->get('doctrine')->getManager();
      //new \DateTime()
      $today = date("d-M-Y");
      $filename = "Programacion_".$today;
      $path = $this->getContainer()->get('kernel')->getRootDir()."/../web/Programaciones/";

      // ask the service for a 2007 excel
      $phpExcelObject = $this->getContainer()->get('phpexcel')->createPHPExcelObject();
      $phpExcelObject->getProperties()->setCreator("liuggio")
          ->setLastModifiedBy("Gestion IPre")
          ->setKeywords("IPre");
      //set headers
        //Sigla 
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A1', "Sigla");
        //Sec 
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('B1', "Sec");
        //Cr. 
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('C1', "Cr.");
        //Semestre  
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('D1', "Semestre");
        //Calificación  
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('E1', "Calificación");
        //Nombre curso  
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('F1', "Nombre Curso");
        //Nombre y Apellidos Profesor 
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('G1', "Nombre y Apellidos Profesor");
        //RUN //Profesor  
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('H1', "RUN Profesor");
        //Retiro  
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('I1', "Retiro");
        //Vacantes  
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('J1', "Vacantes");
        //Horario
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('K1', "Horario");
      //set data
      $number = 1;
      foreach ($dataArray as $research) 
      {
        $number++;
        //Sigla 
        $phpExcelObject->getActiveSheet()->setCellValue("A".$number, $research->getInitialsCode().$research->getNumbersCode());
        //Sec 
        $phpExcelObject->getActiveSheet()->setCellValue("B".$number, $research->getSection());
        //Cr. 
        $phpExcelObject->getActiveSheet()->setCellValue("C".$number, $research->getCredits());
        //Semestre  
        $phpExcelObject->getActiveSheet()->setCellValue("D".$number, $research->getSection());
        //Calificación  
        switch ($research->getModalityOP()) {
          case 1:
            $method = "Estandar (Nota de 1.0 a 7.0)";
            break;
          case 2:
            $method = "Alfanumerico (Aprobado/Reprobado)";
            break;
        }
        $phpExcelObject->getActiveSheet()->setCellValue("E".$number, $method);
        //Nombre curso  
        $classCodeArray = $em->getRepository('BackendBundle:Application')->getClassCode($research->getOportunityResearch(), $research->getStudent());
        $phpExcelObject->getActiveSheet()->setCellValue("F".$number, $classCodeArray["name"]);
        //Nombre y Apellidos Profesor 
        $mentorsName = "";
        foreach ($research->getMentorsNameWResponsible() as $name) {
          if ($mentorsName != "")
            $mentorsName = $mentorsName."\n";
          $mentorsName = $mentorsName.$name;
        }
        $phpExcelObject->getActiveSheet()->setCellValue("G".$number, $mentorsName);
        $phpExcelObject->getActiveSheet()->getStyle('G'.$number)->getAlignment()->setWrapText(true);
        //RUN //Profesor  
        $mentorsRut = "";
        foreach ($research->getMentorsRutWResponsible() as $rut) {
          if ($mentorsRut != "")
            $mentorsRut = $mentorsRut."\n";
          $mentorsRut = $mentorsRut.$rut;
        }
        $phpExcelObject->getActiveSheet()->setCellValue("H".$number, $mentorsRut);
        $phpExcelObject->getActiveSheet()->getStyle('H'.$number)->getAlignment()->setWrapText(true);
        //$phpExcelObject->getActiveSheet()->setCellValue("H".$number, $research->getMentorsRutWResponsible());
        //Retiro  
        $phpExcelObject->getActiveSheet()->setCellValue("I".$number, "No retirable");
        //Vacantes  
        $phpExcelObject->getActiveSheet()->setCellValue("J".$number, 10);
        //Horario        
        $phpExcelObject->getActiveSheet()->setCellValue("K".$number, "Sin horario");
      }
      //agregamos los bordes
      $styleArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => \PHPExcel_Style_Border::BORDER_THIN,
                  'color' => array('argb' => '000000'),
              ),
          ),
      );
      $phpExcelObject->getActiveSheet()->getStyle('A1:K'.$number)->applyFromArray($styleArray);
      //headers bold
      $phpExcelObject->getActiveSheet()->getStyle("A1:K1")->getFont()->setBold(true);
      //autosize a las columnas
      $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      //nombre de la hoja
      $phpExcelObject->getActiveSheet()->setTitle('Hoja 1');
      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $phpExcelObject->setActiveSheetIndex(0);
      // Save Excel 2007 file        
      $writer = $this->getContainer()->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
      $writer->save($path.$filename.".xlsx");
    }
    //Hardcoded report :S
    private function generateInscripcionXLSX($dataArray)
    {
      $em = $this->getContainer()->get('doctrine')->getManager();
      //new \DateTime()
      $today = date("d-M-Y");
      $filename = "Inscripcion_".$today;
      $path = $this->get('kernel')->getRootDir()."web/Inscripciones/";
      // ask the service for a 2007 excel
      $phpExcelObject = $this->getContainer()->get('phpexcel')->createPHPExcelObject();
      $phpExcelObject->getProperties()->setCreator("liuggio")
          ->setLastModifiedBy("Gestion IPre")
          ->setKeywords("IPre");
      //set headers
        //Sigla 
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A1', "Sigla");
        //Sec 
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('B1', "Sec");
        //Cr. 
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('C1', "Cr.");
        //Semestre  
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('D1', "Semestre");
        //Nombre Curso  
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('E1', "Nombre Curso");
        //Nombre y Apellidos Alumno  
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('F1', "Nombre y Apellidos Alumno");
        //RUN Alumno
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('G1', "RUN Alumno");
      //set data
      $number = 1;
      foreach ($dataArray as $research) 
      {
        $number++;
        //Sigla 
        $phpExcelObject->getActiveSheet()->setCellValue("A".$number, $research->getInitialsCode().$research->getNumbersCode());
        //Sec 
        $phpExcelObject->getActiveSheet()->setCellValue("B".$number, $research->getSection());
        //Cr. 
        $phpExcelObject->getActiveSheet()->setCellValue("C".$number, $research->getCredits());
        //Semestre  
        $semester = $em->getRepository('BackendBundle:Research')->getSemester($research);
        $phpExcelObject->getActiveSheet()->setCellValue("D".$number, $semester);
        //Nombre Curso
        $classCodeArray = $em->getRepository('BackendBundle:Application')->getClassCode($research->getOportunityResearch(), $research->getStudent());
        $phpExcelObject->getActiveSheet()->setCellValue("E".$number, $classCodeArray["name"]);
        //Nombre y Apellidos Alumno
        $phpExcelObject->getActiveSheet()->setCellValue("F".$number, $research->getStudent()->getFullName());
        //RUN Alumno 
        $phpExcelObject->getActiveSheet()->setCellValue("G".$number, $research->getStudent()->getRutText());
      }
      //agregamos los bordes
      $styleArray = array(
          'borders' => array(
              'allborders' => array(
                  'style' => \PHPExcel_Style_Border::BORDER_THIN,
                  'color' => array('argb' => '000000'),
              ),
          ),
      );
      $phpExcelObject->getActiveSheet()->getStyle('A1:G'.$number)->applyFromArray($styleArray);
      //headers bold
      $phpExcelObject->getActiveSheet()->getStyle("A1:G1")->getFont()->setBold(true);
      //autosize a las columnas
      $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $phpExcelObject->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      //nombre de la hoja
      $phpExcelObject->getActiveSheet()->setTitle('Hoja 1');
      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $phpExcelObject->setActiveSheetIndex(0);
      // Save Excel 2007 file        
      $writer = $this->getContainer()->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
      $writer->save($path.$filename.".xlsx");
    }
}