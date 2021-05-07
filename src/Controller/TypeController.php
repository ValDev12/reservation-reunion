<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\TypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeController extends AbstractController
{
     /**
     * @Route("/type/add", name="typeController_type_add")
     */
    public function add(Request $request): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeForm::class, $type,[]);
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
        return $this->render('type/listeType.html.twig', [
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
        $form = $this->createForm(TypeForm::class, $type,[]);
        $form -> handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($type);
            $em->flush();

            return $this->redirectToRoute('typeController_type_list');
        }
        else
        {
            return $this->render('type/updateType.html.twig', ['formulaire' => $form->createView(),]);
        }
    }

    /**
     * @Route("/type/delete/{id}", name="typeController_type_delete")
     */
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $type = $this->getDoctrine()->getRepository(Type::class)->find($id);
        if (!$type)
        {
            throw $this->createNotFoundException('Aucun type avec l\'id '.$id);
        }
        elseif($type->getSalles() == NULL)
        {
            throw $this->createNotFoundException('Le type est lier à une salle'.$type->getNom());
        }
        else
        {
            $em->remove($type);
            $em->flush();
        }
        return $this->redirectToRoute('typeController_type_list');
    }
}
