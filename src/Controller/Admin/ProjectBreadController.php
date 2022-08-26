<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Entity\ComplexPage;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/projects')]
class ProjectBreadController extends AbstractController
{
	#[Route('/', name: 'admin_project_browse')]
	public function browse(ProjectRepository $pRepo): Response
	{
		$projects = $pRepo->findAll();
		
		return $this->render('admin/projects/bread/browse.html.twig', [
			'projects' => $projects
		]);
	}
	
	#[Route('/read/{id}', name: 'admin_project_read')]
	public function read(Project $project): Response
	{
		return $this->render('admin/projects/bread/read.html.twig', [
			'project' => $project,
		]);
	}
	
	#[Route('/edit/{id}', name: 'admin_project_edit')]
	public function edit(Request $request, EntityManagerInterface $em, Project $project): Response
	{
		$form = $this->createForm(ProjectType::class, $project);
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()) {
			$em->flush();
			
			return $this->redirectToRoute('admin_project_read', ['id' => $project->getId()]);
		}
		
		return $this->render('admin/projects/bread/edit.html.twig', [
			'edit_form' => $form->createView(),
		]);
	}
	
	#[Route('/add', name: 'admin_project_add')]
	public function add(Request $request, EntityManagerInterface $em): Response
	{
		$project = new Project();
		$form = $this->createForm(ProjectType::class, $project);
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()) {
			// TODO: Upload image and set url?
			$page = $project->getPage();
			$hotlink = $page->getHotlink();
			$widget = $project->getWidget();
			
			$hotlink->setPageNamespace($page::class);
			
			$em->persist($project);
			$em->persist($page);
			$em->persist($hotlink);
			$em->persist($widget);
			$em->flush();
			
			return $this->redirectToRoute('admin_project_read', ['id' => $project->getId()]);
		}
		
		return $this->render('admin/projects/bread/add.html.twig', [
			'add_form' => $form->createView(),
		]);
	}
	
	#[Route('/delete/{id}', name: 'admin_project_delete')]
	public function delete(Request $request, EntityManagerInterface $em, Project $project): Response
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
			$em->remove($project);
			$em->flush();
			
			return $this->redirectToRoute('admin_project_browse');
		}
		
		return $this->render('admin/projects/bread/delete.html.twig', [
			'delete_confirm_form' => $form->createView(),
			'project' => $project,
		]);
	}
}
