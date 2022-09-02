<?php

namespace App\Service;

use App\Entity\Hotlink;
use App\Entity\AbstractPage;
use App\Entity\AbstractWidget;
use App\Component\Pages\PageTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use App\Component\Widgets\WidgetTypeEnum;
use App\Repository\SupportedLanguageRepository;

class CreateNewDataSets
{
	public function __construct(
		private SupportedLanguageRepository $slRepo,
		private EntityManagerInterface $em
	) {}
	
	public function createForWidget(AbstractWidget $widget): bool
	{
		try {
			foreach($this->slRepo->findAll() as $lang) {
				$widgetType = WidgetTypeEnum::tryFrom($widget::class);
				
				if(!$widgetType instanceof WidgetTypeEnum) {
					return false;
				}
				
				$dataName = $widgetType->getDataType();
				
				($newData = new $dataName())
					->setSupportedLanguage($lang)
					->setWidget($widget);
				
				$widget->addData($newData);
			}
			
			return true;
		} catch(\Exception $e) {
			return false;
		}
	}
	
	public function createForPage(AbstractPage $page): bool
	{
		try {
			foreach($this->slRepo->findAll() as $lang) {
				$pageType = PageTypeEnum::tryFrom($page::class);
				
				if(!$pageType instanceof PageTypeEnum) {
					return false;
				}
				
				$dataName = $pageType->getDataType();
				
				($newHotlink = new Hotlink())
					->setPageDataNamespace($pageType->getDataType())
					->setPageNamespace($page::class);
				
				($newData = new $dataName())
					->setSupportedLanguage($lang)
					->setHotlink($newHotlink)
					->setPage($page);
					
				$newHotlink
					->setRoute(strval($page->getIdentifier()));
				
				$page->addData($newData);
			}
			
			return true;
		} catch(\Exception $e) {
			return false;
		}
	}
}
