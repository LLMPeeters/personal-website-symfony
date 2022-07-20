<?php

namespace App\Component\Pages\FormType;

use App\Entity\ComplexPage;
use Symfony\Component\Form\FormBuilderInterface;
use App\Component\Pages\FormType\AbstractPageType;
use App\Component\Pages\FormType\ComplexPageItemType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ComplexPageType extends AbstractPageType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		// dd($options['data']->getElements());
        parent::buildForm($builder, $options);
        
        $builder
            ->add('elements', CollectionType::class, [
				'entry_type' => ComplexPageItemType::class,
				'entry_options' => [
					'label' => false,
					'attr' => [
						'draggable' => 'true',
					],
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
            'data_class' => ComplexPage::class,
        ]);
    }

}