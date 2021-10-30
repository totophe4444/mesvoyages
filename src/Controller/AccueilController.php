<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AccueilController
 *
 * @author tophe
 */
class AccueilController extends AbstractController {
     
    /**
     * @Route("/", name="accueil")
     * @return Response
     */
    public function index(): Response {
        return $this->render("pages/accueil.html.twig");
        //return new Response($this->twig->render("pages/accueil.html.twig"));
        //return new Response("Hello world!");
    }
}
