<?php

namespace App\Component\Widgets\WidgetType;

use App\Entity\ProjectWidget;
use App\Component\Widgets\AbstractWidgetType;

class ProjectWidgetType extends AbstractWidgetType
{
    public function getEntityName(): string
	{
		return ProjectWidget::class;
	}
}