<?php

namespace App\Component\Widgets\WidgetType;

use App\Entity\ProgressWidget;
use App\Component\Widgets\AbstractWidgetType;

class ProgressWidgetType extends AbstractWidgetType
{
    public function getEntityName(): string
	{
		return ProgressWidget::class;
	}
}