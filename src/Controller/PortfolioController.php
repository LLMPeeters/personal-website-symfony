<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    #[Route('/{route}', name: 'app_portfolio', requirements: ['route' => '^(?!api|admin)[a-zA-Z_\/]*$'])]
    public function index(string $route): Response
    {
        return $this->render('portfolio/index.html.twig', [
            'controller_name' => 'PortfolioController',
        ]);
    }
}
