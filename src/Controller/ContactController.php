<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;

use Doctrine\ORM\EntityManagerInterface;




class ContactController extends AbstractController
   
  {
     /**
      * @Route("/", name="home")
      */
      public function home()
      {
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();

         return $this->render('home.html.twig', [
            "contacts"=> $contacts
         ]);
      }

  
  /**
    *@Route("/contact/{id}", name="contact")
    */
    public function contact ($id) 
    {
        $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);
        return $this->render('contact.html.twig', [
            "contact"=> $contact
        ]);

    }

     /**
     * @Route("/add", name="add")
     */

    public function add()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $contact = new Contact();
        $contact->setNom('Laffitte');
        $contact->setPrenom('jean-marc');
        $contact->setTelephone('0123456789');
        $contact->setAdresse('35 rue du null');
        $contact->setVille('Paris');
        $contact->setAge('28');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($contact);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('<h1> Le contact a été enregistré. Son id est ' . $contact->getId() . '</h1>');
    }

     /**
     * @Route("/update/{id}", name="update")
     */

    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $contacts = $entityManager->getRepository(Contact::class)->find($id);

        $contacts->setTelephone('New number!');
        $entityManager->flush();

        return $this->render('home.html.twig', [
            "contacts"=> $contacts
         ]);

        
    }


     /**
     * @Route("/delete/{id}", name="delete")
     */

    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $contacts = $entityManager->getRepository(Contact::class)->find($id);

        $entityManager->remove($contacts);
        $entityManager->flush();

        return $this->render('home.html.twig', [
            "contacts"=> $contacts
            ]);

    }



  
}