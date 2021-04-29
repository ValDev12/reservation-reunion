<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/utilisateur/add", name="utilisateurController_utilisateur_add")
     */
    public function add(Request $request): Response
    {
        $utilisateur = new Utilisateur();
        $utilisateurs = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $form = $this->createForm(UtilisateurUtilisateur::class, $utilisateur,[
            'utilisateurs' => $utilisateurs,
         ]);
        $form -> handleRequest($request);
        if ($form-> isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
            return $this->redirectToRoute('utilisateurController_utilisateur_list',);
        }
        else
        {
            return $this->render('utilisateur/addUtilisateur.html.twig', ['formulaire' => $form->createView()]);
        }
    }

    /**
     * @Route("/utilisateur/list", name="utilisateurController_utilisateur_list")
     */
    public function list(): Response
    {
        $utilisateurs = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        $roles = $this->getDoctrine()->getRepository(Role::class)->findAll();
        return $this->render('utilisateur/index.html.twig', [
            'liste_utilisateurs' => $utilisateurs,
            'roles' => $roles,
        ]);
    }

    /**
     * @Route("/utilisateur/update/{id}", name="utilisateurController_utilisateur_update")
     */
    public function update($id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $roles = $this->getDoctrine()->getRepository(Role::class)->findAll();
        $utilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        if(!$utilisateur)
        {
            throw $this->createNotFoundException
            (
                'Aucun utilisateur trouvée avec l\'id'.$id
            );
        }
        if(!$roles)
        {
            throw $this->createNotFoundException
            (
                'Aucun rôle(s) trouvée avec l\'id'.$id
            );
        }
        $form = $this->createForm(UtilisateurType::class, $utilisateur,[
            'roles' => $roles,
        ]);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('utilisateurController_utilisateur_list');
        }
        else
        {
            return $this->render('utilisateur/addUtilisateur.html.twig', ['formulaire' => $form->createView(),]);
        }
    }

    /**
     * @Route("/utilisateur/delete/{id}", name="utilisateurController_utilisateur_delete")
     */
    public function delete($id): Response
    {
        $utilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        if (!$utilisateur)
        {
            throw $this->createNotFoundException('Aucun utilisateur avec l\'id '.$id);
        }
        else
        {
            $em->remove($utilisateur);
            $em->flush();
        }
        return $this->redirectToRoute('utilisateur');
    }
}
