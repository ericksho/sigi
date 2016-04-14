<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\Research;


/**
 * Reporter controller.
 *
 * @Route("/reporter")
 */
class ReporterController extends Controller
{
    /**
     * Lists all unsend researches entities.
     *
     * @Route("/unsendResearches", name="reporter_unsendresearches")
     * @Method("GET")
     */
    public function unsendResearchesAction()
    {
      $em = $this->getDoctrine()->getManager();

      $researches = $em->getRepository('BackendBundle:Research')->findAll();

      $this->generateProgramacionXLSX($researches);
      $this->generateInscripcionXLSX($researches);

      return $this->render('reporter/unsendResearches.html.twig', array(
          'researches' => $researches,
      ));


    }

    //Hardcoded report :S
    private function generateProgramacionXLSX($dataArray)
    {
      //new \DateTime()
      $today = date("d-M-Y");
      $filename = "Programacion_".$today;
      $path = "";
      // ask the service for a 2007 excel
      $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

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
        $phpExcelObject->getActiveSheet()->setCellValue("F".$number, $research->getSection());
        //Nombre y Apellidos Profesor 
        $phpExcelObject->getActiveSheet()->setCellValue("G".$number, $research->getSection());
        //RUN //Profesor  
        $phpExcelObject->getActiveSheet()->setCellValue("H".$number, $research->getSection());
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
      $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
      $writer->save($path.$filename.".xlsx");
    }




    //Hardcoded report :S
    private function generateInscripcionXLSX($dataArray)
    {
      $em = $this->getDoctrine()->getManager();

      //new \DateTime()
      $today = date("d-M-Y");
      $filename = "Inscripcion".$today;
      $path = "";

      // ask the service for a 2007 excel
      $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

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
      $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
      $writer->save($path.$filename.".xlsx");
    }

}
