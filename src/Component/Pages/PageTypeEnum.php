<?php

namespace App\Component\Pages;

use App\Entity\ComplexPage;
use App\Entity\SimpleTextPage;
use App\Entity\ComplexPageData;
use App\Entity\SimpleTextPageData;

enum PageTypeEnum: string
{
	case SIMPLE_TEXT = SimpleTextPage::class;
	case COMPLEX = ComplexPage::class;
	
	public function getDataType(): string
	{
		return match($this->value) {
			SimpleTextPage::class => SimpleTextPageData::class,
			ComplexPage::class => ComplexPageData::class,
		};
	}
}