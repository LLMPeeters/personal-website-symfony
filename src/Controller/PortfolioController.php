<?php

namespace App\Controller;

use LogicException;
use App\Entity\Hotlink;
use App\Entity\ComplexPage;
use App\Entity\AbstractPage;
use App\Entity\SimpleTextPage;
use App\Repository\HotlinkRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PortfolioController extends AbstractController
{
    #[Route('/{route}', name: 'app_portfolio', requirements: ['route' => '^(?!api|admin|user)[a-zA-Z_\/]*$'])]
    public function index(string $route, HotlinkRepository $hRepo, ManagerRegistry $doctrine): Response
    {
        $hotlink = $hRepo->findOneBy(['route' => $route]);
        
        if($hotlink instanceof Hotlink && is_subclass_of($hotlink->getPageNamespace(), AbstractPage::class)) {
            $repo = $doctrine->getRepository($hotlink->getPageNamespace());
            $page = $repo->findOneBy(['hotlink' => $hotlink]);
            
            if($page instanceof SimpleTextPage) {
                return $this->render('portfolio/simple_page.html.twig', [
                    'page' => $page
                ]);
            } elseif($page instanceof ComplexPage) {
				return $this->render('portfolio/complex_page.html.twig', [
					'page' => $page,
				]);
			}
        }
        
        throw new LogicException('Something went wrong in PortfolioController!');
    }
}
