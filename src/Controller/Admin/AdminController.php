<?php

namespace App\Controller\Admin;

use App\Component\Pages\ComplexPageItemsEnum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'disk_space' => round(disk_free_space('/') / 1000000000, 4),
        ]);
    }
}
