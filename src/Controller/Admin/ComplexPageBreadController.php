<?php

namespace App\Controller\Admin;

use App\Entity\ComplexPage;
use App\Entity\SimpleTextPage;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ComplexPageRepository;
use App\Repository\SimpleTextPageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Component\Pages\FormType\ComplexPageType;
use App\Component\Pages\FormType\SimpleTextPageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/complex_page')]
class ComplexPageBreadController extends AbstractController
{
    #[Route('/', name: 'admin_complex_page_browse')]
    public function browse(ComplexPageRepository $cpRepo): Response
    {
        $pages = $cpRepo->findAll();
        
        return $this->render('admin/pages/complex_page_bread/browse.html.twig', [
            'pages' => $pages
        ]);
    }
    
    #[Route('/read/{id}', name: 'admin_complex_page_read')]
    public function read(ComplexPage $page): Response
    {
        return $this->render('admin/pages/complex_page_bread/read.html.twig', [
            'page' => $page,
        ]);
    }
    
    #[Route('/edit/{id}', name: 'admin_complex_page_edit')]
    public function edit(Request $request, EntityManagerInterface $em, ComplexPage $page): Response
    {
        $form = $this->createForm(ComplexPageType::class, $page);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            
            return $this->redirectToRoute('admin_complex_page_read', ['id' => $page->getId()]);
        }
        
        return $this->render('admin/pages/complex_page_bread/edit.html.twig', [
            'edit_form' => $form->createView(),
        ]);
    }
    
    #[Route('/add', name: 'admin_complex_page_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $page = new ComplexPage();
        $form = $this->createForm(ComplexPageType::class, $page);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $page->getHotlink()->setpageNamespace(ComplexPage::class);
            
            $em->persist($page);
            $em->persist($page->getHotlink());
            $em->flush();
            
            return $this->redirectToRoute('admin_complex_page_read', ['id' => $page->getId()]);
        }
        
        return $this->render('admin/pages/complex_page_bread/add.html.twig', [
            'add_form' => $form->createView(),
        ]);
    }
    
    #[Route('/delete/{id}', name: 'admin_complex_page_delete')]
    public function delete(Request $request, EntityManagerInterface $em, ComplexPage $page): Response
    {
        $form = ($this->createFormBuilder())
            ->add('confirm', SubmitType::class, [
                'label' => 'Confirm deletion?',
                'attr' => [
                    'class' => 'btn btn-danger',
                ],
            ])
            ->getForm()
        ;
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $em->remove($page);
            $em->flush();
            
            return $this->redirectToRoute('admin_complex_page_browse');
        }
        
        return $this->render('admin/pages/complex_page_bread/delete.html.twig', [
            'delete_confirm_form' => $form->createView(),
            'page' => $page,
        ]);
    }
}
