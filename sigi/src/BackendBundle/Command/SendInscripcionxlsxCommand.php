<?php
// src/BackendBundle/Command/GreetCommand.php
namespace BackendBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SendInscripcionxlsxCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('send:inscripcion')
            ->setDescription('Envia la inscripcion de cursos los 1 de cada mes')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $emailDara = $em->getRepository('BackendBundle:EmailList')->findOneByName('Email Dara');
        $researches = $em->getRepository('BackendBundle:Research')->inscriptionUnsendedToDara();
        try
        { 
            $this->generateInscripcionXLSX($researches);
        }
        catch(Exception $e)
        {
            $output->writeln($e->getMessage());
            return $e->getMessage();
        } 
        $date = date("d-M-Y h:i:s");
        $output->writeln($date.": Inscripcion generada");

        //enviar por email
        $today = date("d-M-Y");
        $filename = "Inscripcion_".$today;
        $path = $this->getContainer()->get('kernel')->getRootDir()."/../web/Inscripciones/";

        $message = \Swift_Message::newInstance()
            ->setSubject('Inscripcion de alumnos a Cursos IPre')
            ->setFrom('gestionIPre@ing.puc.cl')
            ->setTo(array($emailDara->getEmail()))
            ->setBody("Hola, adjuntamos la inscripción de alumnos a cursos IPre de este mes, saludos, \nGestión IPre")
            ->attach(\Swift_Attachment::fromPath($path.$filename.".xlsx"))
        ;
        $this->getContainer()->get('mailer')->send($message);
        $output->writeln($date.": Inscripcion enviada");
        
        // seteamos los estados como inscripciones envadas a dara
        foreach ($researches as $research) {
          $research->getApplication()->setStatus(5);
        }
    }

    //Hardcoded report :S
    private function generateInscripcionXLSX($dataArray)
    {
      $em = $this->getContainer()->get('doctrine')->getManager();
      //new \DateTime()
      $today = date("d-M-Y");
      $filename = "Inscripcion_".$today;
      $path = $this->getContainer()->get('kernel')->getRootDir()."/../web/Inscripciones/";

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