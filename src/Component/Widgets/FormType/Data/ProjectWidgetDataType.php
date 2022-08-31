<?php

namespace App\Component\Widgets\FormType\Widget;

use App\Entity\ProjectWidgetData;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Component\Widgets\FormType\Data\AbstractWidgetDataType;

class ProjectWidgetDataType extends AbstractWidgetDataType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        
        $builder
			->add('summary', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectWidgetData::class,
        ]);
    }

}