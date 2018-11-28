<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Topic;
use App\Form\TopicType;//import du constructeur de formulaire pour l'entité topic


class TopicController extends AbstractController
{

    /**
     * @Route("/topic/add", name="topic_add")
     */

    public function add(Request $request)
    {
        $topic = new Topic();

        $form = $this->createFormBuilder($topic)->add('name', TextType::class)//on construit un form basé sur l'objet topic
                                                ->add('submit', SubmitType::class)
                                                //->add('id', HiddenType::class)
                                                ->getForm();

                                                //gestion du formulaire généré
                                                //on connecte le formulaire avec la requete (Request)
                                                $form->handleRequest($request);

                                                if ($form->isSubmitted()) {
                                                  //on hydrate l'objet topic avec les données du form
                                                  $topic = $form->getData();
                                                  $em = $this->getDoctrine()->getManager();
                                                  //j'ai oublié le persist comme une c****
                                                  $em->persist($topic);
                                                  //merci mr antoine
                                                  $em->flush();
                                                  return $this->redirectToRoute('topic');
                                                }


        return $this->render('topic/add.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/topic", name="topic")
     */
    public function index(){


      $repo = $this->getDoctrine()->getRepository(Topic::class);
      $topics = $repo->findAll();

      return $this ->render('topic/index.html.twig', array(
        'topics'=>$topics

      ));
    }
    /**
     * @Route("/topic/new", name="topic_new")
     */
     public function new ( Request $request)
     {
       $topic =new Topic();
       $form = $this->createForm(TopicType::class, $topic);


       return $this->render('topic/add.html.twig', [
           'form'=> $form->createView()
       ]);
     }
}
