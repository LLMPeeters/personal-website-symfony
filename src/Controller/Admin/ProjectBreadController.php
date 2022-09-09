<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Entity\ComplexPage;
use App\Service\FileRemover;
use App\Service\FileUploader;
use App\Form\ConfirmationType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
	public function edit(Request $request, EntityManagerInterface $em, Project $project, FileUploader $fileUploader, FileRemover $fileRemover, string $imageDirectory): Response
	{
		$form = $this->createForm(ProjectType::class, $project);
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()) {
			$widget = $project->getWidget();
			$potentialImage = $form
				->get('widget')
				->get('uploadedImage')
				->get('image')
				->getData();
			
			if($potentialImage instanceof UploadedFile) {
				// fileName can never be falsy, except when something went wrong.
				if($fileName = $fileUploader->upload($potentialImage)) {
					$newImage = new Image();
					$newImage->setFileName($fileName);
					
					// If an old image exists, delete it
					if(($oldImage = $project->getWidget()->getImage()) instanceof Image) {
						$fileRemover->remove($imageDirectory.'/'.$oldImage->getFileName());
						
						$em->remove($oldImage);
					}
					
					$widget->setImage($newImage);
					
					$em->persist($newImage);
				}
			}
			
			$em->flush();
			
			return $this->redirectToRoute('admin_project_read', ['id' => $project->getId()]);
		}
		
		return $this->render('admin/projects/bread/edit.html.twig', [
			'edit_form' => $form->createView(),
		]);
	}
	
	#[Route('/add', name: 'admin_project_add')]
	public function add(Request $request, EntityManagerInterface $em, FileUploader $fileUploader): Response
	{
		$project = new Project();
		$form = $this->createForm(ProjectType::class, $project);
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()) {
			$page = $project->getPage();
			$widget = $project->getWidget();
			$newImage = $form
				->get('widget')
				->get('uploadedImage')
				->get('image')
				->getData();
			
			if($newImage instanceof UploadedFile) {
				($image = new Image())
					->setFileName($fileUploader->upload($newImage));
				$widget->setImage($image);
				
				$em->persist($image);
			}
			
			foreach($page->getData() as $data) {
				$em->persist($data->getHotlink());
				$em->persist($data);
			}
			
			foreach($widget->getData() as $data) {
				$em->persist($data);
			}
			
			$em->persist($project);
			$em->persist($page);
			$em->persist($widget);
			
			$em->flush();
			
			return $this->redirectToRoute('admin_project_read', ['id' => $project->getId()]);
		}
		
		return $this->render('admin/projects/bread/add.html.twig', [
			'add_form' => $form->createView(),
		]);
	}
	
	#[Route('/delete/{id}', name: 'admin_project_delete')]
	public function delete(Request $request, EntityManagerInterface $em, Project $project, FileRemover $fileRemover, string $imageDirectory): Response
	{
		$form = $this->createForm(ConfirmationType::class);
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()) {
			$page = $project->getPage();
			$widget = $project->getWidget();
			$potentialImage = $widget->getImage();
			
			foreach($page->getData() as $data) {
				$em->remove($data->getHotlink());
				$em->remove($data);
			}
			
			foreach($widget->getData() as $data) {
				$em->remove($data);
			}
			
			if($potentialImage instanceof Image) {
				$fileRemover->remove($imageDirectory.'/'.$potentialImage->getFileName());
				
				$em->remove($potentialImage);
			}
			
			$em->remove($page);
			$em->remove($widget);
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
