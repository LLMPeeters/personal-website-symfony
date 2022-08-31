<?php

namespace App\Component\Pages\FormType\Page;

use App\Entity\SimpleTextPage;
use App\Service\CreateNewPageDataSet;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Component\Pages\FormType\Page\AbstractPageType;
use App\Component\Pages\FormType\Data\SimpleTextPageDataType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SimpleTextPageType extends AbstractPageType
{
	public function __construct(
		private CreateNewPageDataSet $createSet
	) {}
	
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		parent::buildForm($builder, $options);
		
		if(is_null($options['data']->getId())) {
			$this->createSet->create($options['data']);
		}
		
		// dd($options['data']);
		$builder
			->add('data', CollectionType::class, [
				'entry_type' => SimpleTextPageDataType::class,
			])
		;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SimpleTextPage::class,
        ]);
    }
}
