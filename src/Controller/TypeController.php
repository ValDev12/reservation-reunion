<?php

namespace App\Controller;

use App\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class TypeController extends AbstractController
{
    /**
     * @Route("/type", name="type")
     */
    public function index(): Response
    {
        return $this->render('type/index.html.twig', [
            'controller_name' => 'TypeController',
        ]);
    }

     /**
     * @Route("/type/add", name="typeController_type_add")
     */
    public function add(Request $request): Response
    {
        $type = new Type();
        $types = $this->getDoctrine()->getRepository(Type::class)->findAll();
        $form = $this->createForm(TypeType::class, $type,[
            'types' => $types,
         ]);
        $form -> handleRequest($request);
        if ($form-> isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
            return $this->redirectToRoute('typeController_type_list',);
        }
        else
        {
            return $this->render('type/addType.html.twig', ['formulaire' => $form->createView()]);
        }
    }

    /**
     * @Route("/type/list", name="typeController_type_list")
     */
    public function list(): Response
    {
        $types = $this->getDoctrine()->getRepository(Type::class)->findAll();
        return $this->render('type/index.html.twig', [
            'liste_types' => $types,
        ]);
    }

    /**
     * @Route("/type/update/{id}", name="typeController_type_update")
     */
    public function update($id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $type = $this->getDoctrine()->getRepository(Type::class)->find($id);
        if(!$type)
        {
            throw $this->createNotFoundException
            (
                'Aucun type trouvée avec l\'id'.$id
            );
        }
        $form = $this->createForm(TypeType::class, $type,[
        ]);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($type);
            $em->flush();

            return $this->redirectToRoute('typeController_type_list');
        }
        else
        {
            return $this->render('type/addType.html.twig', ['formulaire' => $form->createView(),]);
        }
    }

    /**
     * @Route("/type/delete/{id}", name="typeController_type_delete")
     */
    public function delete($id): Response
    {
        $type = $this->getDoctrine()->getRepository(Type::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        if (!$type)
        {
            throw $this->createNotFoundException('Aucun type avec l\'id '.$id);
        }
        else
        {
            $em->remove($type);
            $em->flush();
        }
        return $this->redirectToRoute('type');
    }
}
