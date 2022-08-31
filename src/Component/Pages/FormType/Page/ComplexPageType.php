<?php

namespace App\Component\Pages\FormType\Page;

use App\Entity\ComplexPage;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Component\Pages\FormType\Page\AbstractPageType;
use App\Component\Pages\FormType\Data\ComplexPageDataType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ComplexPageType extends AbstractPageType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		parent::buildForm($builder, $options);
		
		$builder
			->add('data', CollectionType::class, [
				'entry_type' => ComplexPageDataType::class,
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
