<?php

namespace App\Form;

use App\Entity\SupportedLanguage;
use Symfony\Component\Form\AbstractType;
use App\Repository\SupportedLanguageRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LanguageSelectType extends AbstractType
{
	public function __construct(
		private SupportedLanguageRepository $slRepo
	) {}
	
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		// $languages = $this->slRepo->findAll();
		// $choices = [];
		
		// foreach($languages as $lang) {
		// 	// TODO: Need the translated countries for each code as well, ideally
		// 	$choices[$lang->getCountryCode()] = $lang->getCountryCode();
		// }
		
        $builder
            ->add('languages', EntityType::class, [
				'class' => SupportedLanguage::class,
				'mapped' => false,
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => '',
        ]);
    }
}
