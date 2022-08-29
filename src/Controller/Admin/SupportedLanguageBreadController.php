<?php

namespace App\Controller\Admin;

use App\Entity\SupportedLanguage;
use App\Form\SupportedLanguageType;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\SupportedLanguageRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/languages/supported_language')]
class SupportedLanguageBreadController extends AbstractController
{
    #[Route('/', name: 'admin_supported_language_browse')]
    public function browse(SupportedLanguageRepository $slRepo): Response
    {
        $languages = $slRepo->findAll();
        
        return $this->render('admin/languages/supported_languages_bread/browse.html.twig', [
            'languages' => $languages
        ]);
    }
    
    #[Route('/add', name: 'admin_supported_language_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $language = new SupportedLanguage();
        $form = $this->createForm(SupportedLanguageType::class, $language);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($language);
            $em->flush();
            
            return $this->redirectToRoute('admin_supported_language_browse');
        }
        
        return $this->render('admin/languages/supported_languages_bread/add.html.twig', [
            'add_form' => $form->createView(),
        ]);
    }
    
    #[Route('/delete/{id}', name: 'admin_supported_language_delete')]
    public function delete(Request $request, EntityManagerInterface $em, SupportedLanguage $language): Response
    {
        $form = ($this->createFormBuilder())
            ->add('confirm', SubmitType::class, ['label' => 'Confirm deletion?'])
            ->getForm()
        ;
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $em->remove($language);
            $em->flush();
            
            return $this->redirectToRoute('admin_supported_language_browse');
        }
        
        return $this->render('admin/languages/supported_languages_bread/delete.html.twig', [
            'delete_confirm_form' => $form->createView(),
            'language' => $language,
        ]);
    }
}
