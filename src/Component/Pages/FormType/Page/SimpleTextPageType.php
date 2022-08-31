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
		// TODO: Maybe add a service that will create empty data entities to couple to this $options['data']?
		// TODO: Call method that checks if the page is new or not?
		
		$this->createSet->create($options['data']);
		
		
		// dd($options['data']);
		// TODO: Add a SimpleTextPageDataType for each SupportedLanguage entity that exists, and give the SupportedLanguage entity along as an option
		$builder
			->add('data', CollectionType::class, [
				'entry_type' => SimpleTextPageDataType::class,
			])
		;
		
		// dd($builder);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SimpleTextPage::class,
        ]);
    }
}
