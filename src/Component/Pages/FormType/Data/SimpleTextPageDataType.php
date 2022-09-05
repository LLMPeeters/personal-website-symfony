<?php

namespace App\Component\Pages\FormType\Data;

use App\Entity\SimpleTextPageData;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Component\Pages\FormType\Data\AbstractPageDataType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SimpleTextPageDataType extends AbstractPageDataType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		parent::buildForm($builder, $options);
		
		$builder
			->add('rawHtml', TextareaType::class, [
				'required' => false,
			])
		;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
		parent::configureOptions($resolver);
		
        $resolver->setDefaults([
            'data_class' => SimpleTextPageData::class,
        ]);
    }
}
