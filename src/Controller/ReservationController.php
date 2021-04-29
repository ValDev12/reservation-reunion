<?php

namespace App\Controller;
use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

    /**
     * @Route("/reservation/list", name="list_r")
     */
    public function list(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $res = $this->getDoctrine()->getRepository(Reservation::class)->findAll();
        return $this->render('reservation/AfficheReservation.html.twig', [
            'reservations' => $res,
        ]);
    }


     /**
     * @Route("/reservation/add/{id}", name="add_r")
     */
    public function add(Request $req): Response
    {
        $uneReservation= new Reservation();
        $entityManager = $this->getDoctrine()->getManager();
        $users  = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        for ($i=0;$i<count($users);$i++)
        {
            if(in_array($id, $users[$i]->getId()))
            {
                $leCreateur=$users[$i];
                $i=count($users);
            }
        }
        $uneReservation->setCreateur($leCreateur);
        $usersAll  = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $salles  = $this->getDoctrine()->getRepository(Salle::class)->findAll();
        $form=$this->createForm(ReservationType::class ,$uneReservation,['utilisateurs'=>$usersAll,'salles'=>$salles,]);

        $form-> handleRequest($req);
        if($form->isSubmitted())
        {
           $entityManager->persist($uneReservation);
            $entityManager->flush();
            $response=$this->redirectToRoute('list_r');
        }
        else
        {
            $response= $this->render('reservation/AjoutReservation.html.twig',['formulaire' => $form->createView(), ]);
        }   
             return $response;
    }
}