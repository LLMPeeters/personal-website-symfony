<?php

namespace App\Controller\Admin;

use App\Entity\ProgressWidget;
use App\Form\ConfirmationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProgressWidgetRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Component\Widgets\FormType\Widget\ProgressWidgetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/widgets/progress_widget')]
class ProgressWidgetBreadController extends AbstractController
{
    #[Route('/', name: 'admin_progress_widget_browse')]
    public function browse(ProgressWidgetRepository $pwRepo): Response
    {
        $widgets = $pwRepo->findAll();
        
        return $this->render('admin/widgets/progress_widget_bread/browse.html.twig', [
            'widgets' => $widgets
        ]);
    }
    
    #[Route('/read/{id}', name: 'admin_progress_widget_read')]
    public function read(ProgressWidget $widget): Response
    {
        return $this->render('admin/widgets/progress_widget_bread/read.html.twig', [
            'widget' => $widget,
        ]);
    }
    
    #[Route('/edit/{id}', name: 'admin_progress_widget_edit')]
    public function edit(Request $request, EntityManagerInterface $em, ProgressWidget $widget): Response
    {
        $form = $this->createForm(ProgressWidgetType::class, $widget);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            
            return $this->redirectToRoute('admin_progress_widget_read', ['id' => $widget->getId()]);
        }
        
        return $this->render('admin/widgets/progress_widget_bread/edit.html.twig', [
            'edit_form' => $form->createView(),
        ]);
    }
    
    #[Route('/add', name: 'admin_progress_widget_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $widget = new ProgressWidget();
        $form = $this->createForm(ProgressWidgetType::class, $widget);
        $form->handleRequest($request);
		
        if($form->isSubmitted() && $form->isValid()) {
			foreach($widget->getData() as $data) {
				$em->persist($data);
			}
			
            $em->persist($widget);
            $em->flush();
            
            return $this->redirectToRoute('admin_progress_widget_read', ['id' => $widget->getId()]);
        }
        
        return $this->render('admin/widgets/progress_widget_bread/add.html.twig', [
            'add_form' => $form->createView(),
        ]);
    }
    
    #[Route('/delete/{id}', name: 'admin_progress_widget_delete')]
    public function delete(Request $request, EntityManagerInterface $em, ProgressWidget $widget): Response
    {
		$form = $this->createForm(ConfirmationType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
			foreach($widget->getData() as $data) {
				$em->remove($data);
			}
			
            $em->remove($widget);
			
            $em->flush();
            
            return $this->redirectToRoute('admin_progress_widget_browse');
        }
        
        return $this->render('admin/widgets/progress_widget_bread/delete.html.twig', [
            'delete_confirm_form' => $form->createView(),
            'widget' => $widget,
        ]);
    }
}
