<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UtilisateurType;
use App\Entity\Role;
use Symfony\Component\Validator\Constraints\Length;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    /**
     * @Route("utilisateur/add", name="utilisateur_add")
     */
    public function add(Request $req): Response
    {
        $user = new Utilisateur();
        $roles = $this->getDoctrine()->getRepository(Role::class)->findAll();
        $form = $this->createForm(UtilisateurType::class, $user, ['role' => $roles]);
  
        $form->handleRequest($req);
  
        if($form->isSubmitted() && $form->isValid())
        {
            $entity = $this->getDoctrine()->getManager();
  
            $entity->persist($user);
  
            $entity->flush();
  
            return $this-> redirectToRoute('utilisateur');
          
        }
        else
        {
            return $this->render('utilisateur/add.html.twig', ['formulaire' => $form->createView(),]);
        }
    }

    /**
     * @Route("utilisateur/list", name="utilisateur_list")
     */
    public function list(): Response
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class);
        $users = $user->findAll();
        return $this->render('utilisateur/list.html.twig', ['utilisateurs' => $users]) ;
    }

    /**
     * @Route("utilisateur/update/{id}", name="utilisateur_update")
     */
    public function update($id, Request $req): Response
    {
        $entity = $this->getDoctrine()->getManager();
        $user = $entity->getRepository(Utilisateur::class)->find($id);
        $roles = $entity->getRepository(Role::class)->findAll();
        $form = $this->createForm(UtilisateurType::class, $user, ['role' => $roles]);

        $form->handleRequest($req);

        if($form->isSubmitted())
        {
            $entity->persist($user);

            $entity->flush();

            return $this-> redirectToRoute('utilisateur_list');
        
        }
        else
        {
            return $this->render('utilisateur/update.html.twig', ['formulaire' => $form->createView(),]);
        }
    }

    /**
     * @Route("utilisateur/delete/{id}", name="utilisateur_delete")
     */
    public function delete($id): Response
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        if (!$user)
        {
            throw $this->createNotFoundException('Aucun utilisateur avec l\'id '.$id);
        }
        else
        {
            $em->remove($user);
            $em->flush();
        }
        return $this->redirectToRoute('utilisateur_list');
    }
}
