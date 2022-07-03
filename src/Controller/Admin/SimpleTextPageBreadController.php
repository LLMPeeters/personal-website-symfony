<?php

namespace App\Controller\Admin;

use App\Repository\SimpleTextPageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/simple_text_page')]
class SimpleTextPageBreadController extends AbstractController
{
    #[Route('/', name: 'admin_simple_text_page_browse')]
    public function browse(SimpleTextPageRepository $stpRepo): Response
    {
        $pages = $stpRepo->findAll();
        
        return $this->render('admin/simple_text_page_bread/browse.html.twig', [
            'pages' => $pages
        ]);
    }
    
    #[Route('/read', name: 'admin_simple_text_page_read')]
    public function read(): Response
    {
        return $this->render('admin/simple_text_page_bread/read.html.twig', [
            
        ]);
    }
    
    #[Route('/edit', name: 'admin_simple_text_page_edit')]
    public function edit(): Response
    {
        return $this->render('admin/simple_text_page_bread/edit.html.twig', [
            
        ]);
    }
    
    #[Route('/add', name: 'admin_simple_text_page_add')]
    public function add(): Response
    {
        return $this->render('admin/simple_text_page_bread/add.html.twig', [
            
        ]);
    }
    
    #[Route('/delete', name: 'admin_simple_text_page_delete')]
    public function delete(): Response
    {
        return $this->render('admin/simple_text_page_bread/delete.html.twig', [
            
        ]);
    }
}
