<?php

namespace App\Controller;

use LogicException;
use App\Entity\Hotlink;
use App\Entity\AbstractPage;
use App\Service\NavDataFinder;
use App\Entity\ComplexPageData;
use App\Service\PagesToSitemap;
use App\Entity\AbstractPageData;
use App\Form\LanguageSelectType;
use App\Service\RouteValidifier;
use App\Entity\SupportedLanguage;
use App\Entity\SimpleTextPageData;
use App\Component\Pages\PageTypeEnum;
use App\Repository\HotlinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Component\Pages\ComplexPageItemsEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\SupportedLanguageRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Component\Config\ForbiddenRoutePrefixesEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PortfolioController extends AbstractController
{
    #[Route(
		'/{route}',
		name: 'app_portfolio',
		requirements: ['route' => '%app.allowed_routes_regex%']
	)]
    public function index(
		Request $request,
		RouteValidifier $rValidifier,
		string $route,
		HotlinkRepository $hRepo,
		ManagerRegistry $doctrine,
		PagesToSitemap $pagesToSitemap,
		NavDataFinder $navDataFinder,
		SupportedLanguageRepository $slRepo
	): Response {
		/**
		 * First find a valid SupportedLanguage
		 * Then find a valid Hotlink by using the route and SupportedLanguage
		 * Then find the AbstractPageData that has a (fake) OneToOne relation with Hotlink
		 */
        if(($lang = $rValidifier->getValidLang($route))) {
			$hotlink = $hRepo->findOneBy([
				'route' => substr($route, 3),
				'supportedLanguage' => $lang
			]);
			
			if($hotlink instanceof Hotlink) {
				$repo = $doctrine->getRepository($hotlink->getPageDataNamespace());
				$pageData = $repo->findOneBy(['hotlink' => $hotlink]);
				$navPages = $navDataFinder->getNavData($lang);
				$sitemapData = $pagesToSitemap->getSitemapArray($lang);
				$renderData = [
					'page_data' => $pageData,
					'nav_data' => $navPages,
					'sitemap_data' => $sitemapData,
				];
				
				if($pageData instanceof AbstractPageData) {
					if($pageData instanceof SimpleTextPageData) {
						return $this->render('portfolio/simple_page.html.twig', $renderData);
					} elseif($pageData instanceof ComplexPageData) {
						return $this->render('portfolio/complex_page.html.twig', $renderData);
					} else {
						throw new \LogicException('Unrecognized page type.');
					}
				}
			}
		} elseif($url = $rValidifier->getValidRedirect($route)) {
			return $this->redirect($url);
		}
		
		throw new NotFoundHttpException('Page not found.');
    }
}
