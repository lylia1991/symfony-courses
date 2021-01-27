<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use App\Form\ContactType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ContactController extends AbstractController
   
  {
     /**
      * @Route("/", name="home")
      */
      public function home()
      {
        // $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();

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
            "id" => $id,
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
        $contact->setNom('Le grand');
        $contact->setPrenom('Nicolas');
        $contact->setTelephone('0123456789');
        $contact->setAdresse('45 rue');
        $contact->setVille('Paris');
        $contact->setAge('35');

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

        // return $this->render('home.html.twig', [
        //     "contacts"=> $contacts
        //  ]);

        return $this->redirectToRoute('home');
        
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

        // return $this->render('home.html.twig', [
        //     "contacts"=> $contacts
        //     ]);

        return $this->redirectToRoute('home');

    }
    
    /**
     * @Route("/add-contact", name="add-new-contact")
     */

    public function addContact(Request $request)
    {
        $new_contact = new Contact;

        $form = $this->createForm(ContactType::class, $new_contact);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($new_contact);
           $entityManager->flush();
           
            $this->addFlash("contact_add_success", "Votre contact a été ajouté avec succès");
            return $this->redirectToRoute('home');
        
        }
   
        return $this->render('ajouter.html.twig', [
            "form" => $form->createView()
        ]);
    }



    /**
     * @Route("/edit-contact/{id}", name="edit-contact")
     */
     
    public function editContact($id, Request $request)
    {
      $contact = $this->getDoctrine()->getRepository(Contact::class)->find($id);
      $form = $this->createForm(ContactType::class, $contact);
      $form->handleRequest($request);
  
      if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
  
        $this->addFlash("contact_edit_success", "Contact modifié avec succès");
        return $this->redirectToRoute('home');
      }
  
      return $this->render('modifier.html.twig', [
        "form" => $form->createView()
      ]);
    }


}