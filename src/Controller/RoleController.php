<?php

namespace App\Controller;

use App\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

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
     * @Route("/role/add", name="roleController_role_add")
     */
    public function add(Request $request): Response
    {
        $role = new Role();
        $roles = $this->getDoctrine()->getRepository(Role::class)->findAll();
        $form = $this->createForm(RoleType::class, $role,[
            'roles' => $roles,
         ]);
        $form -> handleRequest($request);
        if ($form-> isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();
            return $this->redirectToRoute('roleController_role_list',);
        }
        else
        {
            return $this->render('role/addRole.html.twig', ['formulaire' => $form->createView()]);
        }
    }
    
    /**
     * @Route("/role/list", name="roleController_role_list")
     */
    public function list(): Response
    {
        $roles = $this->getDoctrine()->getRepository(Role::class)->findAll();
        return $this->render('role/index.html.twig', [
            'liste_roles' => $roles,
        ]);
    }

    /**
     * @Route("/role/update/{id}", name="roleController_role_update")
     */
    public function update($id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $role = $this->getDoctrine()->getRepository(Role::class)->find($id);
        if(!$role)
        {
            throw $this->createNotFoundException
            (
                'Aucun role trouvée avec l\'id'.$id
            );
        }
        $form = $this->createForm(RoleType::class, $role,[]);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($role);
            $em->flush();

            return $this->redirectToRoute('roleController_role_list');
        }
        else
        {
            return $this->render('role/addRole.html.twig', ['formulaire' => $form->createView(),]);
        }
    }

    /**
     * @Route("/role/delete/{id}", name="roleController_role_delete")
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
        return $this->redirectToRoute('role');
    }
}
