<?php

namespace App\Component\Widgets\FormType\Widget;

use App\Entity\ProgressWidget;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Component\Widgets\FormType\Widget\AbstractWidgetType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Component\Widgets\FormType\Data\ProgressWidgetDataType;

class ProgressWidgetType extends AbstractWidgetType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('data', CollectionType::class, [
				'entry_type' => ProgressWidgetDataType::class,
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProgressWidget::class,
        ]);
    }

}