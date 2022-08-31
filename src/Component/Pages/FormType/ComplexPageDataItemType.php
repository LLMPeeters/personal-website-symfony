<?php

namespace App\Component\Pages\FormType;

use Symfony\Component\Form\AbstractType;
use App\Component\Widgets\WidgetsManager;
use App\Component\Pages\ComplexPageItemsEnum;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ComplexPageDataItemType extends AbstractType
{
	public function __construct(
		private WidgetsManager $wManager
	) {}
	
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$types = array_combine(
			array_column(ComplexPageItemsEnum::cases(), 'name'),
			array_column(ComplexPageItemsEnum::cases(), 'value')
		);
		$widgetNames = $this->wManager->getSpecialArray();
		
		$builder
			->add('types', ChoiceType::class, [
				'label' => false,
				'choices' => $types,
				'attr' => [
					'class' => 'form-select',
				],
			])
			->add('content', TextareaType::class, [
				'label' => false,
				'required' => false,
				'attr' => [
					'class' => 'form-control',
				],
			])
			->add('widgetChoices', ChoiceType::class, [
				'choices' => $widgetNames
			])
		;
	}
}