<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Color;


class ColorController extends AbstractController
{

  public function color($color, $width, $height, $number){
    return $this->render('color/color.html.twig', array(

      'color'=>$color,
      'width'=>$width,
      'height'=>$height,
      'number'=>$number

    ));
  }

  public function add(Request $request){//injection de dependance

    //var_dump($_POST);
    //var_dump($request);
    //echo $request->getMethod();

    //Pour accéder aux paramètres URL des requêtes GET
    //http://127.0.0.1:8000/color/add?test=blabla
    ///renvoi blabla
    //echo $request->query->get('test');

    $success = false;
    $method = $request->getMethod();
    if($method === 'POST')
    {
      $nameEn = $request->get('nameEn');
      $nameFr = $request->get('nameFr');
      $hexa = $request->get('hexa');


      //insertion en base de données

      //l'objet manager permet d'écrire en base de donnée
      $em = $this->getDoctrine()->getManager();


      //Création d'un objet couleur à partir d'un objet posté
      $color = new Color();
      $color->setNameEn($nameEn);
      $color->setNameFr($nameFr);
      $color->setHexa($hexa);

      $em->persist($color);

      $em->flush();

        if($color->getId() != NULL)
        {

            $success=true;
        }
        else
        {
            $success = false;
        }
      }


    return $this->render('color/add.html.twig', array (
      'success'=>$success,
      'method'=>$method
    ));
  }

  public function list(){

    //récuperer les couleurs en DB (lecture)
    $repo = $this->getDoctrine()->getRepository(Color::class);
    $colors = $repo->findAll();

    return $this ->render('color/list.html.twig', array(
      'colors'=>$colors

    ));
  }

  public function edit($id, Request $request){

    $success=false;

    $method= $request->getMethod();

    //recuperation de la couleur en CD
    $em = $this->getDoctrine()->getManager();


   // Appel au repository a partir du manager,
   //avantage: dans le cas d'un update, toute modification apportée a l'objet recupérée par le repository generera une requete de mise a jour en DB des lors que flush() est appelée depuis le manager
    $color= $em->getRepository(Color::class)
               ->find($id);

    if($method === 'POST')
    {
      $nameEn = $request->get('nameEn');
      $nameFr = $request->get('nameFr');
      $hexa = $request->get('hexa');

      $color->setNameEn($nameEn);
      $color->setNameFr($nameFr);
      $color->setHexa($hexa);

      $em->flush();
      //$success=true;
      //Redirection vers la page d'accueil
      return $this->redirectToRoute('index');


    }

    return $this->render('color/edit.html.twig', array(
      'method'=>$method,
      'color'=>$color
    ));
  }

  public function delete($id){


    $em =$this->getDoctrine()->getManager();
    $color= $em->getRepository(Color::class)->find($id);
    $em->remove($color);
    $em->flush();
    return $this->redirectToRoute('index');

  }




}
