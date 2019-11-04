<?php


namespace App\Controller;

use App\Zoo\Zoo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function index(Zoo $zoo)
    {
        return $this->render('default/index.html.twig', compact('zoo'));
    }
}