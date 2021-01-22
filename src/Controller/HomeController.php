<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Home;



class HomeController extends AbstractController
   
  {
     /**
      * @Route("/", name="home")
      */
      public function home()
      {
        $contacts =  [
            [
                'id' => 1,
                'nom' => 'Durand',
                'prenom' => 'Emilie',
                'telephone' => "0123456789"
                
            ],

            [
                'id' => 2,
                'nom' => 'Hugo',
                'prenom' => 'Dupont',
                'telephone' => "0123456789"
                
            ],

            [
                'id' => 3,
                'nom' => 'Tank',
                'prenom' => 'Thor',
                'telephone' => "0123456789"
                
            ]
        ]; 

         return $this->render('home.html.twig', [
            "contacts"=> $contacts
         ]);
      }

//    /**
//    * @Route("/contact", name="contact")
//   */

//    public function contact()
//     {
//   return $this->render('contact.html.twig');
//      }

  
  /**
    *@Route("/contact/{id}", name="contact")
    */
    public function contact ($id) 
    {
        return $this->render('contact.html.twig', [
            'id' =>$id,
            
        ]);

    }
  
}