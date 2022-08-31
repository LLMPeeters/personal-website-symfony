<?php

namespace App\Controller;

use LogicException;
use App\Entity\Hotlink;
use App\Entity\AbstractPage;
use App\Service\NavDataFinder;
use App\Entity\ComplexPageData;
use App\Service\PagesToSitemap;
use App\Entity\SupportedLanguage;
use App\Entity\SimpleTextPageData;
use App\Component\Pages\PageTypeEnum;
use App\Repository\HotlinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Component\Pages\ComplexPageItemsEnum;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\SupportedLanguageRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Component\Config\ForbiddenRoutePrefixesEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PortfolioController extends AbstractController
{
    #[Route('/{route}', name: 'app_portfolio', requirements: ['route' => '%app.allowed_routes_regex%'])]
    public function index(string $route, HotlinkRepository $hRepo, ManagerRegistry $doctrine, PagesToSitemap $pagesToSitemap, SupportedLanguageRepository $slRepo, NavDataFinder $navDataFinder): Response
    {
		// A route always starts with a two letter country code with a slash; en/, nl/
        $hotlink = $hRepo->findOneBy(['route' => substr($route, 3)]);
        
        if($hotlink instanceof Hotlink && is_subclass_of($hotlink->getPageNamespace(), AbstractPage::class)) {
            $repo = $doctrine->getRepository($hotlink->getPageDataNamespace());
            $pageData = $repo->findOneBy(['hotlink' => $hotlink]);
			$supportedLanguage = $slRepo->findOneBy(['countryCode' => substr($route, 0, 2)]);
			
			if(!$supportedLanguage instanceof SupportedLanguage) {
				throw new \Exception('Language not found!');
			}
			
            $navPages = $navDataFinder->getNavData($supportedLanguage);
			$sitemapData = $pagesToSitemap->getSitemapArray($supportedLanguage);
			$renderData = [
				'page_data' => $pageData,
				'nav_data' => $navPages,
				'sitemap_data' => $sitemapData,
			];
			
            if($pageData instanceof SimpleTextPageData) {
                return $this->render('portfolio/simple_page.html.twig', $renderData);
            } elseif($pageData instanceof ComplexPageData) {
				return $this->render('portfolio/complex_page.html.twig', $renderData);
			} else {
				throw new \LogicException('Unrecognized page type.');
			}
        } else {
			throw new NotFoundHttpException('Page not found.');
		}
    }
}
