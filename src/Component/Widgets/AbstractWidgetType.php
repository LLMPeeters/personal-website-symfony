<?php

namespace App\Component\Widgets;

abstract class AbstractWidgetType
{
    abstract public function getEntityName(): string;
}