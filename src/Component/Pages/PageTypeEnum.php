<?php

namespace App\Component\Pages;

use App\Entity\ComplexPage;
use App\Entity\SimpleTextPage;

enum PageTypeEnum: string
{
	case SIMPLE_TEXT = SimpleTextPage::class;
	case COMPLEX = ComplexPage::class;
}