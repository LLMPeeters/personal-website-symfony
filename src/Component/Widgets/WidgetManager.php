<?php

namespace App\Component\Widgets;

use App\Entity\SupportedLanguage;
use Doctrine\ORM\EntityManagerInterface;
use App\Component\Widgets\WidgetTypesEnum;

class WidgetManager
{
	public function __construct(
		private EntityManagerInterface $em
	) {}
	
	public function deleteDataRelatedToLang(SupportedLanguage $lang): bool
	{
		try {
			foreach(WidgetTypesEnum::cases() as $widgetType) {
				$dataName = $widgetType->getDataType();
				$repo = $this->em->getRepository($dataName);
				$widgetData = $repo->findBy(['supportedLanguage' => $lang]);
				
				foreach($widgetData as $data) {
					$this->em->remove($data);
				}
			}
			
			return true;
		} catch(\Exception $e) {
			return false;
		}
	}
	
	public function fillDataForNewLang(SupportedLanguage $lang): bool
	{
		try {
			foreach(WidgetTypesEnum::cases() as $widgetType) {
				$dataName = $widgetType->getDataType();
				$repo = $this->em->getRepository($widgetType->value);
				$widgets = $repo->findAll();
				
				foreach($widgets as $widget) {
					($newData = new $dataName())
						->setSupportedLanguage($lang)
						->setTitle($page->getIdentifier())
						->setWidget($widget);
					
					$this->em->persist($newData);
				}
			}
			
			$this->em->flush();
			
			return true;
		} catch(\Exception $e) {
			return false;
		}
	}
}