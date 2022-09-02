<?php

namespace App\Twig;

use Twig\TwigFunction;
use App\Entity\ProjectWidget;
use App\Entity\AbstractWidget;
use App\Entity\ProgressWidget;
use App\Service\RouteValidifier;
use App\Entity\ProjectWidgetData;
use App\Entity\AbstractWidgetData;
use App\Entity\ProgressWidgetData;
use Twig\Extension\AbstractExtension;
use App\Component\Config\LanguagesEnum;
use App\Component\Widgets\WidgetTypeEnum;
use Doctrine\Persistence\ManagerRegistry;
use App\Component\Pages\ComplexPageItemsEnum;
use Symfony\Component\HttpFoundation\RequestStack;

class AppExtension extends AbstractExtension
{
	private array $uniqueIntegers = [];
	
	public function __construct(
		private ManagerRegistry $doctrine,
		private string $publicProjectsDir,
		private string $publicImageDir,
		private RouteValidifier $rValidifier,
		private RequestStack $requestStack
	) {}
	
	public function getFunctions()
	{
		return [
			new TwigFunction('unserialize', [$this, 'unserialize']),
			new TwigFunction('uniqueInt', [$this, 'getUniqueInteger']),
			new TwigFunction('languageCode', [$this, 'getLanguageFromCode']),
			new TwigFunction('name', [$this, 'className']),
			new TwigFunction('getEnv', [$this, 'getEnvVar']),
			new TwigFunction('isWidget', [$this, 'isWidget']),
			new TwigFunction('getWidget', [$this, 'getWidget']),
			new TwigFunction('isProgressWidget', [$this, 'isProgressWidget']),
			new TwigFunction('isProjectWidget', [$this, 'isProjectWidget']),
		];
	}
	
	public function unserialize(string $input): mixed
	{
		return unserialize($input);
	}
	
	public function getUniqueInteger(): int
	{
		$num = count($this->uniqueIntegers);
		
		$this->uniqueIntegers[] = $num;
		
		return $num;
	}
	
	public function getLanguageFromCode(string $code): string
	{
		return LanguagesEnum::tryFromName($code)?->value ?? 'Unknown';
	}
	
	public function getWidget(string $serializedData): false|AbstractWidgetData
	{
		try {
			$data = unserialize($serializedData);
			$widget = WidgetTypeEnum::tryFrom($data['entityName']);
			
			if(!$widget instanceof WidgetTypeEnum) {
				return false;
			}
			
			$lang = $this->rValidifier->getValidLang($this->requestStack->getCurrentRequest()->getRequestUri());
			$dataName = $widget->getDataType();
			$repo = $this->doctrine->getRepository($dataName);
			$qb = $repo->createQueryBuilder('data')
				->join('data.widget', 'widget')
				->select('data')
				->andWhere('data.supportedLanguage = :lang')
				->setParameter('lang', $lang)
				->andWhere('widget.id = :widgetId')
				->setParameter('widgetId', $data['entityId']);
			$query = $qb->getQuery();
			$widgetData = $query->getResult();
			
			return $widgetData[0] instanceof AbstractWidgetData ? $widgetData[0] : false;
		} catch(\Exception $e) {
			dd($e->getMessage());
			return false;
		}
	}
	
	public function className(object $subject): string
	{
		unserialize('sagafsg');
		return $subject::class;
	}
	
	public function getEnvVar(string $varName): false|string
	{
		if($varName === 'PUBLIC_PROJECTS_DIR') {
			return $this->publicProjectsDir;
		} elseif($varName === 'PUBLIC_IMAGE_DIR') {
			return $this->publicImageDir;
		} else {
			return false;
		}
	}
	
	public function isWidget(string $contentType): bool
	{
		return ComplexPageItemsEnum::WIDGET === ComplexPageItemsEnum::TryFrom($contentType);
	}
	
	public function isProgressWidget(mixed $widget): bool
	{
		return $widget instanceof ProgressWidgetData;
	}
	
	public function isProjectWidget(mixed $widget): bool
	{
		return $widget instanceof ProjectWidgetData;
	}
}