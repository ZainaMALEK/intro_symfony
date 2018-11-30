<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Role;
use App\Form\RoleType;

class RoleController extends AbstractController
{
    /**
     * @Route("/role/add", name="role_add")
     */
     public function add(Request $request)
     {

         $role = new Role();
         $form = $this->createForm(RoleType::class, $role);

         // traitement du submit
         $form->handleRequest($request);
         if ($form->isSubmitted())
         {
           $role = $form->getData();
           $em = $this->getDoctrine()->getManager();
           $em->persist($role);
           $em->flush();
           return $this->redirectToRoute('user');
         }

         return $this->render('user/add.html.twig', [
             'form'=> $form->createView()
         ]);
     }
}
