<?php

namespace App\Component\Pages\FormType;

use App\Entity\ComplexPage;
use Symfony\Component\Form\FormBuilderInterface;
use App\Component\Pages\FormType\AbstractPageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComplexPageType extends AbstractPageType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        
        $builder
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ComplexPage::class,
        ]);
    }

}