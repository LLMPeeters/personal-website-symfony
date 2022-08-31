<?php

namespace App\Component\SupportedLanguages;

use App\Entity\SupportedLanguage;

interface SupportedLanguageHelperInterface
{
	public function deleteDataRelatedToLang(SupportedLanguage $lang): bool;
	public function fillDataForNewLang(SupportedLanguage $lang): bool;
}