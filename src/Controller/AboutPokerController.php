<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutPokerController extends AbstractController
{
    /**
    * @Route(
    *       "/proj/about",
    *       name="about_poker",
    *       methods={"GET","HEAD"}
    * )
    */
    public function aboutPoker(): Response
    {
        return $this->render('poker/about.html.twig');
    }
}
