<?php

namespace App\Twig;

use Twig\TwigFunction;
use App\Entity\ProjectWidget;
use App\Entity\AbstractWidget;
use App\Entity\ProgressWidget;
use App\Service\ProjectHelper;
use App\Service\RouteValidifier;
use App\Entity\ProjectWidgetData;
use App\Entity\AbstractWidgetData;
use App\Entity\ProgressWidgetData;
use Twig\Extension\AbstractExtension;
use App\Component\Config\LanguagesEnum;
use App\Component\Widgets\WidgetTypeEnum;
use App\Repository\ComplexPageRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Component\Pages\ComplexPageItemsEnum;
use App\Repository\SupportedLanguageRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class AppExtension extends AbstractExtension
{
	private array $uniqueIntegers = [];
	
	public function __construct(
		private ManagerRegistry $doctrine,
		private string $publicProjectsDir,
		private string $publicImageDir,
		private RouteValidifier $rValidifier,
		private RequestStack $requestStack,
		private ProjectHelper $pHelper,
		private SupportedLanguageRepository $slRepo
	) {}
	
	public function getFunctions()
	{
		return [
			new TwigFunction('getLangs', [$this, 'getSupportedLanguages']),
			new TwigFunction('getHost', [$this, 'getHostname']),
			new TwigFunction('getUrl', [$this, 'getCurrentAbsoluteUrl']),
			new TwigFunction('checkType', [$this, 'checkDataType']),
			new TwigFunction('unserialize', [$this, 'unserialize']),
			new TwigFunction('uniqueInt', [$this, 'getUniqueInteger']),
			new TwigFunction('languageCode', [$this, 'getLanguageFromCode']),
			new TwigFunction('name', [$this, 'className']),
			new TwigFunction('getEnv', [$this, 'getEnvVar']),
			new TwigFunction('isWidget', [$this, 'isWidget']),
			new TwigFunction('getWidget', [$this, 'getWidget']),
			new TwigFunction('isProgressWidget', [$this, 'isProgressWidget']),
			new TwigFunction('isProjectWidget', [$this, 'isProjectWidget']),
			new TwigFunction('getProjectUrl', [$this, 'getProjectUrlThroughWidgetData']),
		];
	}
	
	public function getSupportedLanguages(): array
	{
		return $this->slRepo->findAll();
	}
	
	public function getHostname(): string
	{
		$url = $this->requestStack->getCurrentRequest()->getSchemeAndHttpHost();
		
		return $url;
	}
	
	public function getCurrentAbsoluteUrl(): string
	{
		$url = $this->requestStack->getCurrentRequest()->getUri();
		
		return $url;
	}
	
	public function checkDataType(mixed $input, string $checkIfThisType): bool
	{
		return match($checkIfThisType) {
			'string' => is_string($input),
			'int' => is_integer($input),
			'float' => is_float($input),
			'bool' => is_bool($input),
			'array' => is_array($input),
			'object' => is_object($input),
			'null' => is_null($input),
			'resource' => is_resource($input),
		};
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
			
			// PROBLEM: Bad fix
			if(preg_match('/^Proxies\\\__CG__\\\/', $data['entityName'])) {
				$data['entityName'] = substr($data['entityName'], 15);
			}
			
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
			return false;
		}
	}
	
	public function className(object $subject): string
	{
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
	
	public function getProjectUrlThroughWidgetData(ProjectWidgetData $data): false|string
	{
		return $this->rValidifier->getUrlFromLangAndPage($data->getWidget()->getProject()->getPage(), $data->getSupportedLanguage());
	}
}