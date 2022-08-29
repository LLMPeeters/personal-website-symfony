<?php

namespace App\Component\Pages\FormType\Page;

class SimpleTextPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
			
		;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SimpleTextPage::class,
        ]);
    }
}
