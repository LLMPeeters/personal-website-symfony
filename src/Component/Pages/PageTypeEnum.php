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
	
	static public function tryByProxy(string $input): ?self
	{
		$result = self::tryFrom($input);
		
		if(!$result instanceof self) {
			foreach(self::cases() as $case) {
				if(is_subclass_of($input, $case->value)) {
					return $case;
				}
			}
			
			return null;
		}
		
		return $result;
	}
}