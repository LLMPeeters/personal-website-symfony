<?php

namespace App\Component\Widgets\FormType\Data;

use App\Entity\ProgressWidgetData;
use Symfony\Component\Form\FormBuilderInterface;
use App\Component\Widgets\FormType\ProgressItemType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Component\Widgets\FormType\Data\AbstractWidgetDataType;

class ProgressWidgetDataType extends AbstractWidgetDataType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('progressBars', CollectionType::class, [
				'entry_type' => ProgressItemType::class,
				'entry_options' => [
					'label' => false,
				],
				'allow_add' => true,
				'allow_delete' => true,
				'prototype' => true,
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProgressWidgetData::class,
        ]);
    }

}