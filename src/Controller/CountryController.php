<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Country;
use App\Form\CountryType;

class CountryController extends AbstractController
{
    /**
     * @Route("/country", name="country")
     */
    public function index()
    {
        $countries = $this->getDoctrine()
        ->getRepository(Country::class)
        //->findAll();
        ->findAllCustom();
        //->findBy([], ['name'=>'ASC']);//findBy permet de parametrer la recherche, le 1er argument permet de filtrer, le 2eme permet de trier

        return $this->render('country/index.html.twig', array(
          'countries'=>$countries
        ));

    }

    /**
     * @Route("/country/new", name="country_new")
     */
    public function new(Request $request)
    {
      $file='';
      $country = new Country();
      $form = $this->createForm(CountryType::class, $country);

      $form->handleRequest($request);
          if ($form->isSubmitted())
          {
            $country = $form->getData();

            $file = $form->get('flag')->getData();
            $fileName = $file->getClientOriginalName();


            try{
              $file->move(
                $this>getParameter('flags_folder'),
                $fileName
              );
            } catch(FileException $e){
              echo'error';
            }


            $em = $this->getDoctrine()->getManager();
            // $em->persist($country);
            // $em->flush();
            // return $this->redirectToRoute('country');
          }

      return $this->render('country/new.html.twig', [
          'form'=> $form->createView()

      ]);

    }

    /**
     * @Route("/country/add", name="country_add")
     */
    public function add(Request $request)
    {
        if ($request->isMethod('POST')) {
          $name = $request->request->get('name');
          $em = $this->getDoctrine()->getManager();
          $country = new Country(ucfirst($name));
          $em->persist($country);
          $em->flush();
          $this->redirectToRoute('country');

        }
        return $this->render('country/add.html.twig', [

        ]);
    }

    /**
     * @Route("/country/edit", name="country_edit")
     */
    public function edit(Request $request)
    {}

      //récuperation des données du pays à modifier





    /**
     * @Route("/country/{id}/delete", name="country_delete")
     */
    public function delete($id){


      $em =$this->getDoctrine()->getManager();
      //$country= $em->getRepository(Country::class)->find($id);
      $country= $this->getDoctrine()->getRepository(Country::class)->find($id);
      $em->remove($country);
      $em->flush();
      return $this->redirectToRoute('country');

    }

    /**
     * @Route("/country/test", name="country_test")
     */
    public function test()
    {

      $countries = $this->getDoctrine()
      ->getRepository(Country::class)
      //->findByPopNumber(3000);
        ->findAllCustom();
        return $this->render('country/test.html.twig',[
        'countries'=> $countries
      ]);

    }
}
