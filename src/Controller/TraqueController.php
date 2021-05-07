<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TraqueController extends AbstractController
{
    /**
     * @Route("/traque/{id}/{date}", name="traque")
     */
    public function traquer($id, $date)
    {
        $dateCible = strtotime($date);
        $reservations = $this->getDoctrine()->getRepository(Reservation::class)->findAll();
        $reservationTypes = $this->getDoctrine()->getRepository(ReservationType::class)->findAll();

        foreach($reservations as $res)
        {
            //Création de la collection des réunion datant de moins de trois jours
            $reservationCibler = array();
            $Infecter = array();

            //Création des deux dateTime pour l'abs
            $res = strtotime($res->getdate());

            //Calcul de l'écart en seconde
            $ecartEnSeconde = abs($res - $dateCible);

            //Conversion des secondes en jours 
            $ecart = ((($ecartEnSeconde%60)%60)%24);

            //Si l'écart est supérieur à 3 (jours)
            if($ecart <= 3)
            {
                //Sauvegarde de les réunion
                $reservationCibler[] = $res; 
            }
        }

        foreach($reservationTypes as $resType)
        {
            foreach($resType as $utilisateurRes)
            {
                if($utilisateurRes->getId() == $id)
                {
                    $Infecter[] = $resType;
                }
            }
        }

        return $Infecter;        
    }
}
