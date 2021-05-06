<?php

namespace App\Controller;
use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Entity\Salle;
use App\Controller;
use App\Form\ReservationType;
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
       
            $unUtilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->find($this->getUser()->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $res = $this->getDoctrine()->getRepository(Reservation::class)->findAll();
            return $this->render('reservation/AfficheReservation.html.twig', [
            'reservations' => $res,'utilisateur'=>$unUtilisateur ,
            ]);
        
    }



    
    /**
     * @Route("/reservation/listResUser/{id}", name="ResController_list_res_user")
     */
    public function listResUser($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $res = $this->getDoctrine()->getRepository(Reservation::class)->find($id);
        return $this->render('reservation/AfficheReservation.html.twig', [
            'reservations' => $res,
        ]);
    }


     /**
     * @Route("/reservation/add/{id}", name="add_r")
     */
    public function add($id,Request $req): Response
    {
        $uneReservation= new Reservation();
        $entityManager = $this->getDoctrine()->getManager();
        $users  = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        for ($i=0;$i<count($users);$i++)
        {
            if($id = $users[$i]->getId())
            {
                $leCreateur=$users[$i];
                $i=count($users);
            }
        }
        $uneReservation->setCreateur($leCreateur);
        $usersAll  = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $salles  = $this->getDoctrine()->getRepository(Salle::class)->findAll();
        $form=$this->createForm(ReservationType::class ,$uneReservation,['participant'=>$usersAll,'salles'=>$salles,]);

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

    /**
     * @Route("/reservation/update/{id}", name="ResController_update")
     */
    public function update($id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $uneReservation = $this->getDoctrine()->getRepository(Reservation::class)->find($id);
        if(!$res)
        {
            throw $this->createNotFoundException
            (
                'Aucun reservation trouvée avec l\'id'.$id
            );
        }
        $form = $this->createForm(ReservationController::class, $uneReservation,[]);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($res);
            $em->flush();

            return $this->redirectToRoute('list_r');
        }
        else
        {
            return $this->render('reservation/AjoutReservation.html.twig', ['formulaire' => $form->createView(),]);
        }
    }

     /**
     * @Route("/reservation/delete/{id}", name="ResController_delete")
     */
    public function delete($id): Response
    {
        $uneReservation = $this->getDoctrine()->getRepository(Reservation::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        if (!$uneReservation)
        {
            throw $this->createNotFoundException('Aucun reservation avec l\'id '.$id);
        }
        else
        {
            $em->remove($uneReservation);
            $em->flush();
        }
        return $this->redirectToRoute('list_r');
    }



}