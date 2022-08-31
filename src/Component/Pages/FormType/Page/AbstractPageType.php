<?php

namespace App\Component\Pages\FormType\Page;

use App\Entity\AbstractPage;
use App\Service\CreateNewPageDataSet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AbstractPageType extends AbstractType
{
	public function __construct(
		private CreateNewPageDataSet $createSet
	) {}
	
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		if(is_null($options['data']->getId())) {
			$this->createSet->create($options['data']);
		}
		
        $builder
			->add('identifier', TextType::class)
			->add('addToNav', CheckboxType::class, [
				'required' => false,
			])
			->add('public', CheckboxType::class, [
				'required' => false,
			])
		;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AbstractPage::class,
        ]);
    }
}
