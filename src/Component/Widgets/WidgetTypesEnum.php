<?php

namespace App\Component\Widgets;

use App\Component\Widgets\WidgetTypes\ProgressBarWidgetType;

enum WidgetTypesEnum: string
{
    case PROGRESS_BAR = ProgressBarWidgetType::class;
}