<?php

namespace App\Controller;

use App\Domain\Zoo\Zoo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ZooController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Zoo $zoo): Response
    {
        return $this->render('default/index.html.twig', [
            'zoo' => $zoo,
        ]);
    }
}
