<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class DemoController extends AbstractController {

  private $title = 'Joueurs';

  public function players()
  {
    $res = new Response('<h1>'.$this->title.'</h1>');
    return $res;

  }

  public function test(){

    //echo "blabla";
    //return new Response('test');

    $colors = ['vert', 'blanc', 'rouge'];

    $colorsDict = [
     ['fr' =>'vert', 'en'=>'green', 'active'=>true],
     ['fr' =>'blanc', 'en'=>'white', 'active'=>false


   ],
     ['fr' =>'rouge', 'en'=>'red', 'active'=>true]
   ];

    return $this->render('demo/test.html.twig', array(
      'title'=>'Template test',
      'colors'=>$colors,
      'colorsDict'=>$colorsDict
    ));
  }

  
}
