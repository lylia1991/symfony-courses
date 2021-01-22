<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class ProductController extends AbstractController
{
    public function index(): Response
    {
        $contacts = $this->getDoctrine()->getRepository(Contact::class)->findAll();
        return $this->render('contact.html.twig', [
            'contact' => $contacts
        ]);
    }

    /**
     * @Route("/add", name="add")
     */

    public function add(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $contact = new Contact();
        $contact->setNom('Dupont');
        $contact->setPrenom('Christine');
        $contact->setTelephone('0123456789');
        $contact->setAdresse('21 Rue de paris');
        $contact->setVille('Lyon');
        $contact->setAge('31');
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($contact);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('<h1> Le contact a été enregistré. Son id est ' . $contact->getId() . '</h1>');
    }
}
