<?php

namespace App\Component\Widgets\FormType\Widget;

use App\Form\ImageType;
use App\Entity\ProjectWidget;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Component\Widgets\FormType\Widget\AbstractWidgetType;
use App\Component\Widgets\FormType\Data\ProjectWidgetDataType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProjectWidgetType extends AbstractWidgetType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
		
        $builder
			->add('data', CollectionType::class, [
				'entry_type' => ProjectWidgetDataType::class,
			])
			->add('uploadedImage', ImageType::class, [
				'mapped' => false,
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectWidget::class,
        ]);
    }

}