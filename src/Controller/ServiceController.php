<?php

namespace App\Controller;

use App\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ServiceType;
use App\Entity\Type;
use App\Entity\Salle;
use Symfony\Component\Validator\Constraints\Length;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     */
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    /**
     * @Route("service/list", name="service_list")
     */
    public function list() : Response
    {
        $service = $this->getDoctrine()->getRepository(Service::class);
        $services = $service->findAll();
        return $this->render('service/list.html.twig', ['services' => $services]) ;
    }

    
     /**
      * @Route("service/add" , name="service_add")
      */
      public function add(Request $req) : Response
      {
           $service = new Service();
           $salles = $this->getDoctrine()->getRepository(Salle::class)->findAll();
           $form = $this->createForm(ServiceType::class, $service, ['salle' => $salles]);
  
           $form->handleRequest($req);
  
          if($form->isSubmitted() && $form->isValid())
          {
              $entity = $this->getDoctrine()->getManager();
  
              $entity->persist($service);
  
              $entity->flush();
  
              return $this-> redirectToRoute('service');
          
          }
          else
          {
              return $this->render('service/add.html.twig', ['formulaire' => $form->createView(),]);
          }
      }

    /**
     * @Route("service/update/{id}", name="service_update")
     */
    public function update($id, Request $req): Response
    {
        $entity = $this->getDoctrine()->getManager();
        $service = $entity->getRepository(Service::class)->find($id);
        $salles = $entity->getRepository(Salle::class)->findAll();
        $form = $this->createForm(ServiceType::class, $service, ['salle' => $salles]);

        $form->handleRequest($req);

        if($form->isSubmitted())
        {
            $entity->persist($service);

            $entity->flush();

            return $this-> redirectToRoute('service_list');
        
        }
        else
        {
            return $this->render('service/update.html.twig', ['formulaire' => $form->createView(),]);
        }
    }

    /**
     * @Route("service/delete/{id}", name="service_delete")
     */
    public function delete($id): Response
    {
        $service = $this->getDoctrine()->getRepository(Service::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        if (!$service)
        {
            throw $this->createNotFoundException('Aucun service avec l\'id '.$id);
        }
        else
        {
            $em->remove($service);
            $em->flush();
        }
        return $this->redirectToRoute('service_list');
    }
}
