<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MetricsController extends AbstractController
{
    /**
    * @Route("/metrics", name="metrics")
    */
    public function metrics(): Response
    {
        return $this->render('metrics/metrics.html.twig', [
            'page' => 'metrics/pages/introduction.markdown.twig',
        ]);
    }

    /**
    * @Route("/metrics/phpmetrics", name="phpmetrics")
    */
    public function phpmetrics(): Response
    {
        return $this->render('metrics/pages/metrics.html.twig', [
            'page' => 'metrics/phpmetrics.markdown.twig',
        ]);
    }

    /**
    * @Route("/metrics/scrutinizer", name="scrutinizer")
    */
    public function scrutinizer(): Response
    {
        return $this->render('metrics/pages/metrics.html.twig', [
            'page' => 'metrics/scrutinizer.markdown.twig',
        ]);
    }

    /**
    * @Route("/metrics/improvements", name="improvements")
    */
    public function improvements(): Response
    {
        return $this->render('metrics/pages/metrics.html.twig', [
            'page' => 'metrics/improvements.markdown.twig',
        ]);
    }

    /**
    * @Route("/metrics/discussion", name="discussion")
    */
    public function discussion(): Response
    {
        return $this->render('metrics/pages/metrics.html.twig', [
            'page' => 'metrics/discussion.markdown.twig',
        ]);
    }
}
