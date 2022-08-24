<?php

namespace App\Component\Widgets;

use App\Component\Widgets\WidgetType\ProgressWidgetType;

enum WidgetTypesEnum: string
{
    case PROGRESS_BAR = ProgressWidgetType::class;
}