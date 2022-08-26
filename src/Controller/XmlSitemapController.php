<?php

namespace App\Controller;

use App\Service\BuildXMLSitemap;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class XmlSitemapController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'app_sitemap_xml')]
    public function index(BuildXMLSitemap $builder): Response
    {
		$urls = $builder->build();
		
		$response = $this->render('xml_sitemap/index.xml.twig', [
			'urls' => $urls,
        ]);
		
		$response->headers->set('Content-Type', 'xml');
		
        return $response;
    }
}
