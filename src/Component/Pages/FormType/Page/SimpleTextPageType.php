<?php

namespace App\Component\Pages\FormType\Page;

use App\Entity\SimpleTextPage;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Component\Pages\FormType\Page\AbstractPageType;
use App\Component\Pages\FormType\Data\SimpleTextPageDataType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SimpleTextPageType extends AbstractPageType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		parent::buildForm($builder, $options);
		
		$builder
			->add('data', CollectionType::class, [
				'entry_type' => SimpleTextPageDataType::class,
			])
		;
		
		// foreach($this->supportedLanguages as $language) {
		// 	$builder
		// 		->add('data', SimpleTextPageDataType::class, [
		// 			'supportedLanguage' => $language,
		// 		])
		// 	;
		// }
		
		dd($builder);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SimpleTextPage::class,
        ]);
    }
}
