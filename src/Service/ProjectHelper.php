<?php

namespace App\Service;

use App\Entity\Project;
use App\Entity\ComplexPage;
use App\Entity\ProjectWidgetData;
use App\Repository\ProjectRepository;
use App\Repository\ComplexPageRepository;

class ProjectHelper
{
	public function __construct(
		private ProjectRepository $pRepo,
		private ComplexPageRepository $cpRepo
	) {}
	
	public function getPageFromWidgetData(ProjectWidgetData $widgetData): ComplexPage
	{
		$qb = $this->cpRepo->createQueryBuilder('page')
			->join(Project::class, 'project')
			->join('project.widget', 'widget')
			->select('page')
			->andWhere('project.page = page')
			->andWhere('project.widget = widget')
			->andWhere(':widgetData MEMBER OF widget.data')
			->setParameter('widgetData', $widgetData);
		
		// $qb = $this->pRepo->createQueryBuilder('project')
		// 	->join('project.widget', 'widget')
		// 	->select('project')
		// 	->andWhere(':widgetData MEMBER OF widget.data')
		// 	->setParameter('widgetData', $widgetData);
		$query = $qb->getQuery();
		$result = $query->getResult();
		
		if($result[0] instanceof ComplexPage) {
			return $result[0];
		}
		
		return false;
	}
}
