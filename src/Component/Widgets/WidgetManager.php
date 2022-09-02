<?php

namespace App\Component\Widgets;

use App\Entity\SupportedLanguage;
use Doctrine\ORM\EntityManagerInterface;
use App\Component\Widgets\WidgetTypeEnum;
use App\Component\Widgets\WidgetTypesEnum;
use App\Component\SupportedLanguages\SupportedLanguageHelperInterface;

class WidgetManager implements SupportedLanguageHelperInterface
{
	public function __construct(
		private EntityManagerInterface $em
	) {}
	
    public function getAllWidgets(): array
	{
		$widgets = [];
		$types = array_column(WidgetTypesEnum::cases(), 'value');
		
		foreach($types as $type) {
			$type = new $type();
			
			foreach($this->em->getRepository($type->getEntityName())->findAll() as $widget) {
				$widgets[] = $widget;
			}
		}
		
		return $widgets;
	}
	
	public function getSpecialArray(): array
	{
		$widgetNames = [];
		
		foreach($this->getAllWidgets() as $widget) {
			$widgetNames[$widget->getIdentifier()] = serialize([
				'entityName' => $widget::class,
				'entityId' => $widget->getId(),
			]);
		}
		
		return $widgetNames;
	}
	
	public function deleteDataRelatedToLang(SupportedLanguage $lang): bool
	{
		try {
			foreach(WidgetTypeEnum::cases() as $widgetType) {
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
			foreach(WidgetTypeEnum::cases() as $widgetType) {
				$dataName = $widgetType->getDataType();
				$repo = $this->em->getRepository($widgetType->value);
				$widgets = $repo->findAll();
				
				foreach($widgets as $widget) {
					($newData = new $dataName())
						->setSupportedLanguage($lang)
						->setTitle($widget->getIdentifier())
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