<?php

namespace App\Controller;

use LogicException;
use App\Entity\Hotlink;
use App\Entity\ComplexPage;
use App\Entity\AbstractPage;
use App\Entity\SimpleTextPage;
use App\Service\PagesToSitemap;
use App\Component\Pages\PageTypeEnum;
use App\Repository\HotlinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Component\Pages\ComplexPageItemsEnum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Component\Config\ForbiddenRoutePrefixesEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PortfolioController extends AbstractController
{
    #[Route('/{route}', name: 'app_portfolio', requirements: ['route' => '%app.allowed_routes_regex%'])]
    public function index(string $route, HotlinkRepository $hRepo, ManagerRegistry $doctrine, PagesToSitemap $pagesToSitemap): Response
    {
		// TODO: Add an automatic xml sitemap
        $hotlink = $hRepo->findOneBy(['route' => $route]);
        
        if($hotlink instanceof Hotlink && is_subclass_of($hotlink->getPageNamespace(), AbstractPage::class)) {
            $repo = $doctrine->getRepository($hotlink->getPageNamespace());
            $page = $repo->findOneBy(['hotlink' => $hotlink]);
            $navPages = [];
			$sitemapData = $pagesToSitemap->getSitemapArray();
			
			foreach(PageTypeEnum::cases() as $type) {
				$navPages = array_merge(
					$navPages,
					$doctrine->getRepository($type->value)->findBy(['addToNav' => true])
				);
			}
			
            if($page instanceof SimpleTextPage) {
                return $this->render('portfolio/simple_page.html.twig', [
                    'page' => $page,
					'nav_pages' => $navPages,
					'sitemap_data' => $sitemapData,
                ]);
            } elseif($page instanceof ComplexPage) {
				return $this->render('portfolio/complex_page.html.twig', [
					'page' => $page,
					'nav_pages' => $navPages,
					'sitemap_data' => $sitemapData,
				]);
			} else {
				throw new \LogicException('Something went terribly wrong with the URL.');
			}
        } else {
			throw new NotFoundHttpException();
		}
    }
}
