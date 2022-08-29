<?php

namespace App\Component\Pages\FormType\Data;

class ComplexPageDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
			
		;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ComplexPageData::class,
        ]);
    }
}
