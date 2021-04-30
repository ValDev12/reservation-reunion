<?php

namespace App\Controller;

use App\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use App\Form\RoleType;

class RoleController extends AbstractController
{
    /**
     * @Route("/role", name="role")
     */
    public function index(): Response
    {
        return $this->render('role/index.html.twig', [
            'controller_name' => 'RoleController',
        ]);
    }

     /**
     * @Route("role/add", name="role_add")
     */
    public function add(Request $req): Response
    {
        $role = new Role();
        /*$users = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();*/
        $form = $this->createForm(RoleType::class, $role, ['utilisateur' => null]);
  
        $form->handleRequest($req);
  
        if($form->isSubmitted() && $form->isValid())
        {
            $entity = $this->getDoctrine()->getManager();
  
            $entity->persist($role);
  
            $entity->flush();
  
            return $this-> redirectToRoute('role_list');
          
        }
        else
        {
            return $this->render('role/add.html.twig', ['formulaire' => $form->createView(),]);
        }
    }
    
    /**
     * @Route("role/list", name="role_list")
     */
    public function list(): Response
    {
        $role = $this->getDoctrine()->getRepository(Role::class);
        $roles = $role->findAll();
        return $this->render('role/list.html.twig', ['roles' => $roles]) ;
    }

    /**
     * @Route("role/update/{id}", name="role_update")
     */
    public function update($id, Request $req): Response
    {
        $entity = $this->getDoctrine()->getManager();
        $role = $entity->getRepository(Role::class)->find($id);
        $users = $entity->getRepository(Utilisateur::class)->findAll();
        $form = $this->createForm(RoleType::class, $role, ['utilisateur' => $users]);

        $form->handleRequest($req);

        if($form->isSubmitted())
        {
            $entity->persist($role);

            $entity->flush();

            return $this-> redirectToRoute('role_list');
        
        }
        else
        {
            return $this->render('role/update.html.twig', ['formulaire' => $form->createView(),]);
        }
    }

    /**
     * @Route("role/delete/{id}", name="role_delete")
     */
    public function delete($id): Response
    {
        $role = $this->getDoctrine()->getRepository(Role::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        if (!$role)
        {
            throw $this->createNotFoundException('Aucun role avec l\'id '.$id);
        }
        else
        {
            $em->remove($role);
            $em->flush();
        }
        return $this->redirectToRoute('role_list');
    }
}
