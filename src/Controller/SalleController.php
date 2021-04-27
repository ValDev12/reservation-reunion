<?php

namespace App\Controller;

use App\Entity\Salle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class SalleController extends AbstractController
{
    /**
     * @Route("/salle", name="salle")
     */
    public function index(): Response
    {
        return $this->render('salle/index.html.twig', [
            'controller_name' => 'SalleController',
        ]);
    }

     /**
     * @Route("/salle/add", name="salleController_salle_add")
     */
    public function add(Request $request): Response
    {
        $salle = new Salle();
        $salles = $this->getDoctrine()->getRepository(Salle::class)->findAll();
        $form = $this->createForm(SalleType::class, $salle,[
            'salles' => $salles,
         ]);
        $form -> handleRequest($request);
        if ($form-> isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($salle);
            $em->flush();
            return $this->redirectToRoute('salleController_salle_list',);
        }
        else
        {
            return $this->render('salle/addSalle.html.twig', ['formulaire' => $form->createView()]);
        }
    }

    /**
     * @Route("/salle/list", name="salleController_salle_list")
     */
    public function list(): Response
    {
        $salles = $this->getDoctrine()->getRepository(Salle::class)->findAll();
        return $this->render('salle/index.html.twig', [
            'liste_salles' => $salles,
        ]);
    }

    /**
     * @Route("/salle/update/{id}", name="salleController_salle_update")
     */
    public function update($id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $salle = $this->getDoctrine()->getRepository(Salle::class)->find($id);
        if(!$salle)
        {
            throw $this->createNotFoundException
            (
                'Aucun salle trouvée avec l\'id'.$id
            );
        }
        $form = $this->createForm(SalleType::class, $salle,[]);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($salle);
            $em->flush();

            return $this->redirectToRoute('salleController_salle_list');
        }
        else
        {
            return $this->render('salle/addSalle.html.twig', ['formulaire' => $form->createView(),]);
        }
    }

    /**
     * @Route("/salle/delete/{id}", name="salleController_salle_delete")
     */
    public function delete($id): Response
    {
        $salle = $this->getDoctrine()->getRepository(Salle::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        if (!$salle)
        {
            throw $this->createNotFoundException('Aucun salle avec l\'id '.$id);
        }
        else
        {
            $em->remove($salle);
            $em->flush();
        }
        return $this->redirectToRoute('salle');
    }
}
