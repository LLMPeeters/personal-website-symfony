<?php

namespace App\Component\Widgets;

use Doctrine\ORM\EntityManagerInterface;
use App\Component\Widgets\WidgetTypesEnum;

class WidgetsManager
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
			$widgetNames[$widget->getName()] = serialize([
				'entityName' => $widget::class,
				'entityId' => $widget->getId(),
			]);
		}
		
		return $widgetNames;
	}
	
	public function getWidgetFromName(): array
	{
		
	}
}