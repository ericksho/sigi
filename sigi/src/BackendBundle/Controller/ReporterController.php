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

      $this->createXLSX("myfile", "", $researches);

      return $this->render('reporter/unsendResearches.html.twig', array(
          'researches' => $researches,
      ));


    }

    //Hardcoded report :S
    private function createXLSX($filename, $path, $dataArray)
    {
      // ask the service for a 2007 excel
      $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

      $phpExcelObject->getProperties()->setCreator("liuggio")
          ->setLastModifiedBy("Giulio De Donato")
          ->setKeywords("IPRE");

      //set headers
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A1', "Nombre");
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('B1', "Descripcion");
      $phpExcelObject->setActiveSheetIndex(0)->setCellValue('C1', "Sigla");


      //set data
      $number = 2;
      foreach ($dataArray as $data) 
      {
        $phpExcelObject->getActiveSheet()->setCellValue("A".$number, $data->getNameOP());
        $phpExcelObject->getActiveSheet()->setCellValue("B".$number, $data->getDescriptionOP());
        $phpExcelObject->getActiveSheet()->setCellValue("C".$number, $data->getInitialsCode().$data->getNumbersCode());
          
        $number++;
      }

      $phpExcelObject->getActiveSheet()->setTitle('Hoja 1');

      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
      $phpExcelObject->setActiveSheetIndex(0);

      // Save Excel 2007 file        
      $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
      $writer->save($path.$filename.".xlsx");
    }

}
