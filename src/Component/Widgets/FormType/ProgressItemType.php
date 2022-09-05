<?php

namespace App\Component\Widgets\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProgressItemType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', TextType::class, [
				'label' => false,
				'attr' => [
					'class' => 'form-control',
				],
			])
			->add('percentage', IntegerType::class, [
				'label' => false,
				'attr' => [
					'class' => 'form-control',
					'min' => 0,
					'max' => 100,
				],
			])
		;
	}
}