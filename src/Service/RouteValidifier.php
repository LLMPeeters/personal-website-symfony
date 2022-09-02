<?php

namespace App\Service;

use App\Entity\Hotlink;
use App\Entity\SupportedLanguage;
use App\Component\Pages\PageTypeEnum;
use App\Repository\HotlinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SupportedLanguageRepository;

class RouteValidifier
{
	public function __construct(
		private SupportedLanguageRepository $slRepo,
		private HotlinkRepository $hRepo,
		private EntityManagerInterface $em
	) {}
	
	public function isLanguageValid(string $route): bool
	{
		$supportedLanguage = $this->slRepo->findOneBy(['countryCode' => substr($route, 0, 2)]);
		
		return $supportedLanguage instanceof SupportedLanguage;
	}
	
	public function getValidLang(string $route): false|SupportedLanguage
	{
		if(preg_match('/^\//', $route)) {
			$route = substr($route, 1);
		}
		
		if($this->isLanguageValid($route)) {
			return $this->slRepo->findOneBy(['countryCode' => substr($route, 0, 2)]);
		} else {
			return false;
		}
	}
	
	public function getValidHomeUrl(): false|string
	{
		if(($lang = $this->slRepo->findOneBy(['main' => true])) instanceof SupportedLanguage) {
			return '/'.$lang->getCountryCode().'/';
		}
		
		return false;
	}
	
	public function getValidRedirect(string $route): false|string
	{
		if(preg_match('/\/$/', $route)) {
			$route = substr($route, 0, strlen($route) - 1);
		}
		
		if(($lang = $this->slRepo->findOneBy(['main' => true])) instanceof SupportedLanguage) {
			foreach(PageTypeEnum::cases() as $pageType) {
				$dataName = $pageType->getDataType();
				$repo = $this->em->getRepository($dataName);
				$qb = $repo->createQueryBuilder('data')
					->join('data.hotlink', 'hotlink')
					->select('data')
					->andWhere('data.supportedLanguage = :lang')
					->setParameter('lang', $lang)
					->andWhere('hotlink.route = :route')
					->setParameter('route', $route);
				$query = $qb->getQuery();
				$results = $query->getResult();
				
				if(is_array($results) && count($results) > 0) {
					return '/'.$results[0]->getRoute();
				}
			}
		}
		
		return false;
	}
}
