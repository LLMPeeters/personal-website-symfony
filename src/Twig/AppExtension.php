<?php

namespace App\Twig;

use Twig\TwigFunction;
use App\Entity\ProjectWidget;
use App\Entity\AbstractWidget;
use App\Entity\ProgressWidget;
use Twig\Extension\AbstractExtension;
use Doctrine\Persistence\ManagerRegistry;
use App\Component\Pages\ComplexPageItemsEnum;

class AppExtension extends AbstractExtension
{
	public function __construct(
		private ManagerRegistry $doctrine,
		private string $publicProjectsDir,
		private string $publicImageDir
	) {}
	
	public function getFunctions()
	{
		return [
			new TwigFunction('name', [$this, 'className']),
			new TwigFunction('getEnv', [$this, 'getEnvVar']),
			new TwigFunction('isWidget', [$this, 'isWidget']),
			new TwigFunction('getWidget', [$this, 'getWidget']),
			new TwigFunction('isProgressWidget', [$this, 'isProgressWidget']),
			new TwigFunction('isProjectWidget', [$this, 'isProjectWidget']),
		];
	}
	
	public function getWidget(string $serializedData): false|AbstractWidget
	{
		try {
			$data = unserialize($serializedData);
			$widget = $this->doctrine->getRepository($data['entityName'])->find($data['entityId']);
			
			return $widget ?? false;
		} catch(\Exception $e) {
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
		return $widget instanceof ProgressWidget;
	}
	
	public function isProjectWidget(mixed $widget): bool
	{
		return $widget instanceof ProjectWidget;
	}
}