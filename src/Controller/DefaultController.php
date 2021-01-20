<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    // public function hello($name)
    // {
    //     return new Response("<h1>Hello $name!</h1>");
    // }

     /**
      * @Route("/hello-world/{name}", name="hello")
      */
    
    public function hello($name)
    {
        return new Response("<h1>Hello $name !</h1>");
    }

}