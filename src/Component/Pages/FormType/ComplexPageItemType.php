<?php

namespace App\Component\Pages\FormType;

use Symfony\Component\Form\AbstractType;
use App\Component\Pages\ComplexPageItemsEnum;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ComplexPageItemType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$types = [];
		
		foreach(ComplexPageItemsEnum::GET_ALL() as $type) {
			$types[$type->name] = $type->value;
		}
		
		$builder
			->add('types', ChoiceType::class, [
				'choices' => $types,
			])
			->add('content', TextareaType::class)
		;
	}
}