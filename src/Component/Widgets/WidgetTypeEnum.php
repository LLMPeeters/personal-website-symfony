<?php

namespace App\Component\Widgets;

use App\Entity\ProjectWidget;
use App\Entity\ProgressWidget;
use App\Entity\ProjectWidgetData;
use App\Entity\ProgressWidgetData;

enum WidgetTypeEnum: string
{
    case PROGRESS = ProgressWidget::class;
	case PROJECT = ProjectWidget::class;
	
	public function getDataType(): string
	{
		return match($this->value) {
			ProgressWidget::class => ProgressWidgetData::class,
			ProjectWidget::class => ProjectWidgetData::class,
		};
	}
}