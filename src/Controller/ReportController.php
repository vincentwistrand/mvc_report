<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    /**
    * @Route("/", name="home")
    */
    public function home(): Response
    {
        $number = random_int(0, 100);

        return $this->render('home.html.twig', [
        'number' => $number,
        ]);
    }

    /**
    * @Route("/report", name="report")
    */
    public function report(): Response
    {
        $number = random_int(0, 100);

        return $this->render('report.html.twig', [
        'number' => $number,
        ]);
    }

    /**
    * @Route("/about", name="about")
    */
    public function about(): Response
    {
        $number = random_int(0, 100);

        return $this->render('about.html.twig', [
        'number' => $number,
        ]);
    }

    /**
     * @Route("/api/lucky/number/{min}/{max}")
     */
    public function number3(int $min, int $max): Response
    {
        $this->number = random_int($min, $max);

        $data = [
            'message' => 'Welcome to the lucky number API',
            'min number' => $min,
            'max number' => $max,
            'lucky-number' => $this->number
        ];

        return new JsonResponse($data);
    }

    /**
    * @Route("/dev/debug", name="debug")
    */
    public function debug(): Response
    {
        $data = [
          'message' => 'Welcome to the lucky number API',
          'number' => random_int(0, 100)
        ];

        return $this->render('debug.html.twig', $data);
    }
}
