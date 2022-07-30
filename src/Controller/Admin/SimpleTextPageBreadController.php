<?php

namespace App\Controller\Admin;

use App\Entity\SimpleTextPage;
use App\Repository\SimpleTextPageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Component\Pages\FormType\SimpleTextPageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

#[Route('/admin/pages/simple_text_page')]
class SimpleTextPageBreadController extends AbstractController
{
    #[Route('/', name: 'admin_simple_text_page_browse')]
    public function browse(SimpleTextPageRepository $stpRepo): Response
    {
        $pages = $stpRepo->findAll();
        
        return $this->render('admin/pages/simple_text_page_bread/browse.html.twig', [
            'pages' => $pages
        ]);
    }
    
    #[Route('/read/{id}', name: 'admin_simple_text_page_read')]
    public function read(SimpleTextPage $page): Response
    {
        return $this->render('admin/pages/simple_text_page_bread/read.html.twig', [
            'page' => $page,
        ]);
    }
    
    #[Route('/edit/{id}', name: 'admin_simple_text_page_edit')]
    public function edit(Request $request, EntityManagerInterface $em, SimpleTextPage $page): Response
    {
        $form = $this->createForm(SimpleTextPageType::class, $page);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            
            return $this->redirectToRoute('admin_simple_text_page_read', ['id' => $page->getId()]);
        }
        
        return $this->render('admin/pages/simple_text_page_bread/edit.html.twig', [
            'edit_form' => $form->createView(),
        ]);
    }
    
    #[Route('/add', name: 'admin_simple_text_page_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $page = new SimpleTextPage();
        $form = $this->createForm(SimpleTextPageType::class, $page);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $page->getHotlink()->setpageNamespace(SimpleTextPage::class);
            
            $em->persist($page);
            $em->persist($page->getHotlink());
            $em->flush();
            
            return $this->redirectToRoute('admin_simple_text_page_read', ['id' => $page->getId()]);
        }
        
        return $this->render('admin/pages/simple_text_page_bread/add.html.twig', [
            'add_form' => $form->createView(),
        ]);
    }
    
    #[Route('/delete/{id}', name: 'admin_simple_text_page_delete')]
    public function delete(Request $request, EntityManagerInterface $em, SimpleTextPage $page): Response
    {
        $form = ($this->createFormBuilder())
            ->add('confirm', SubmitType::class, ['label' => 'Confirm deletion?'])
            ->getForm()
        ;
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $em->remove($page);
            $em->flush();
            
            return $this->redirectToRoute('admin_simple_text_page_browse');
        }
        
        return $this->render('admin/pages/simple_text_page_bread/delete.html.twig', [
            'delete_confirm_form' => $form->createView(),
            'page' => $page,
        ]);
    }
}
