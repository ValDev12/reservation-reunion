<?php

namespace App\Controller;

use App\Entity\Salle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\SalleReservationType;
use App\Entity\Type;
use App\Entity\Service;
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
     * @Route("salle/list", name="salle_list")
     */
    public function list() : Response
    {
        $salle = $this->getDoctrine()->getRepository(Salle::class);
        $salles = $salle->findAll();
        return $this->render('salle/list.html.twig', ['salles' => $salles]) ;
    }

     /**
      * @Route("salle/add" , name="salle_add")
      */
      public function add(Request $req) : Response
      {
           $salle = new Salle();
           $types = $this->getDoctrine()->getRepository(Type::class)->findAll();
           $services = $this->getDoctrine()->getRepository(Service::class)->findAll();
           $form = $this->createForm(SalleReservationType::class, $salle, ['type' => $types, 'service' => $services ]);
  
           $form->handleRequest($req);
  
          if($form->isSubmitted() && $form->isValid())
          {
              $entity = $this->getDoctrine()->getManager();
  
              $entity->persist($salle);
  
              $entity->flush();
  
              return $this-> redirectToRoute('salle');
          
          }
          else
          {
              return $this->render('salle/add.html.twig', ['formulaire' => $form->createView(),]);
          }
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
