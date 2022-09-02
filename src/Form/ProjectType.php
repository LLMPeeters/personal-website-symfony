<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\ComplexPage;
use App\Entity\ProjectWidget;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Component\Pages\FormType\Page\ComplexPageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Component\Widgets\FormType\Widget\ProjectWidgetType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		if(!isset($options['data']) || !$options['data'] instanceof Project) {
			throw new \LogicException('The data option for ProjectType and its descendants should be set to the Project class.');
		}
		
		if(!($projectWidget = $options['data']->getWidget()) instanceof ProjectWidget) {
			$projectWidget = new ProjectWidget();
		}
		
		if(!($complexPage = $options['data']->getPage()) instanceof ComplexPage) {
			$complexPage = new ComplexPage();
		}
		
        $builder
			->add('name', TextType::class)
			->add('hasCode', CheckboxType::class, [
				'required' => false,
			])
			->add('widget', ProjectWidgetType::class, [
				'data' => $projectWidget,
			])
			->add('page', ComplexPageType::class, [
				'data' => $complexPage,
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
