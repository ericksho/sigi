<?php

namespace BackendBundle\Repository;

/**
 * ResearchRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ResearchRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSemester($research)
    {
        $now = new \DateTime();

        $Y = $now->format('Y');

        $date = $research->getCreationDate();
        $date->setDate($Y , $date->format("m") , $date->format("d"));
        //obtenemos el periodo actual
        $endFirst = $this->getEntityManager()->getRepository('BackendBundle:Deadline')->findOneByName("fin primer semestre")->getDate();

        $endSecond = $this->getEntityManager()->getRepository('BackendBundle:Deadline')->findOneByName("fin segundo semestre")->getDate();

        if($endFirst < $date && $date > $endSecond) //segundo semestre
        {   
            return 2;
        }
        else
        {
            return 1;
        }
    }

	public function getSection($classCodeArray, $newResearch)
    {
        $now = new \DateTime();
    	//obtenemos el periodo actual
    	$endFirst = $this->getEntityManager()->getRepository('BackendBundle:Deadline')->findOneByName("fin primer semestre")->getDate();

    	$endSecond = $this->getEntityManager()->getRepository('BackendBundle:Deadline')->findOneByName("fin segundo semestre")->getDate();

    	if($endFirst < $now && $now > $endSecond) //segundo semestre
    	{
    		$endDate = $endSecond;
    		$startDate = $endFirst;
    	}
    	else
    	{
    		$startDate = $endSecond;
    		$endDate = $endFirst;
    	}


    	//cargamos todas las investigaciones del periodo que tengan la misma sigla
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT r FROM BackendBundle:Research r
                WHERE r.creationDate < :endDate
                AND r.creationDate > :startDate
                AND r.initialsCode = :initialsCode
                AND r.numbersCode = :numbersCode'
            )->setParameters(array('startDate' => $startDate->format('Y-m-d'), 'endDate' => $endDate->format('Y-m-d'), 'initialsCode' => $classCodeArray['initialsCode'], 'numbersCode' => $classCodeArray['numbersCode']));
    
        try 
        {
            $researches = $query->getResult();
        }
        catch (\Doctrine\ORM\NoResultException $e) 
        { 
            $$researches = null;
        }

        if(count($researches) == 0 ) //si no hay investigaciones con el criterio, creamos la primera seccion
        {
        	//no hay, lo creamos
        	$section = 1;
        	return $section;
        }
        else
        {
        	//si hay, revisamos que los mentores son iguales
        	$newIds = $newResearch->getMentorsId();
        	asort($newIds);

        	$section = 0;

        	foreach ($researches as $research) 
        	{
	        	$oldIds = $research->getMentorsId();
	        	asort($oldIds);

    	    	if($newIds == $oldIds) //si los mentores son iguales a una investigacion existente
    	    	{
    	    		//revisamos que ambas tengan los mismos profesores responsables
    	    		$newResponsableMentor = $newResearch->getResponsibleMentorObject();
    	    		$oldResponsableMentor = $research->getResponsibleMentorObject();

    	    		if( $newResponsableMentor->getId() == $oldResponsableMentor->getId() ) //si los mentores son iguales usamos esta seccion 
    	    		{
    	    			$section = $research->getSection();
    	    			return $section;
    	    		}//si los mentores no son iguales, seguimos buscando
    	    	}

    	    	if($section < $research->getSection())//guardamos la mayor seccion correlativamente
    	    	{
    	    		$section = $research->getSection();
    	    	}
    	    }

    	    //si llegamos a este punto es porque pasamos por todas las investigaciones sin encontrar acierto, retornamos la siguiente seccion
    	    return $section +1;
        }
    }
}
