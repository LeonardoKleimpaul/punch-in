<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home_page')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'message' => 'Bem-vindo ao front-end do Symfony!',
        ]);
    }
}
