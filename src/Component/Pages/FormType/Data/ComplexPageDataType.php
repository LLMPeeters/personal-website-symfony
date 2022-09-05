<?php

namespace App\Component\Pages\FormType\Data;

use App\Entity\ComplexPageData;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Component\Pages\FormType\ComplexPageDataItemType;
use App\Component\Pages\FormType\Data\AbstractPageDataType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ComplexPageDataType extends AbstractPageDataType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		parent::buildForm($builder, $options);
		
		$builder
			->add('elements', CollectionType::class, [
				'entry_type' => ComplexPageDataItemType::class,
				'entry_options' => [
					'label' => false,
				],
				'allow_add' => true,
				'allow_delete' => true,
				'prototype' => true,
				'attr' => [
					'add-widgets' => true,
				],
			])
		;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
		parent::configureOptions($resolver);
		
        $resolver->setDefaults([
            'data_class' => ComplexPageData::class,
        ]);
    }
}
