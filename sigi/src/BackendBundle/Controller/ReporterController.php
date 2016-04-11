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

        // ask the service for a Excel5
       $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

       $phpExcelObject->getProperties()->setCreator("liuggio")
           ->setLastModifiedBy("Giulio De Donato")
           ->setTitle("Office 2005 XLSX Test Document")
           ->setSubject("Office 2005 XLSX Test Document")
           ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
           ->setKeywords("office 2005 openxml php")
           ->setCategory("Test result file");
       $phpExcelObject->setActiveSheetIndex(0)
           ->setCellValue('A1', 'Hello')
           ->setCellValue('B2', 'world!');
       $phpExcelObject->getActiveSheet()->setTitle('Simple');

       // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       $phpExcelObject->setActiveSheetIndex(0);

        // Save Excel 2007 file        
        $objWriter = PHPExcel_IOFactory::createWriter($phpExcelObject, 'Excel2007');
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));

        return $this->render('reporter/unsendResearches.html.twig', array(
            'researches' => $researches,
        ));


    }

}
