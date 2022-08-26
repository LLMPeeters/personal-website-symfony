<?php

namespace App\Component\Widgets\FormType;

use App\Entity\Project;
use App\Entity\ProjectWidget;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Component\Widgets\FormType\AbstractWidgetType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProjectWidgetType extends AbstractWidgetType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        
        $builder
			->add('image', FileType::class, [
				'required' => false,
				'mapped' => false,
			])
			->add('summary', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectWidget::class,
        ]);
    }

}