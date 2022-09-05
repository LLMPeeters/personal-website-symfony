<?php

namespace App\Component\Widgets;

use App\Entity\ProjectWidget;
use App\Entity\ProgressWidget;
use App\Component\Widgets\WidgetType\ProjectWidgetType;
use App\Component\Widgets\WidgetType\ProgressWidgetType;

enum WidgetTypesEnum: string
{
    case PROGRESS_BAR = ProgressWidgetType::class;
	case PROJECT = ProjectWidgetType::class;
	
	public function getDataType(): string
	{
		return match($this->value) {
			ProgressWidgetType::class => ProgressWidget::class,
			ProjectWidgetType::class => ProjectWidget::class,
		};
	}
}