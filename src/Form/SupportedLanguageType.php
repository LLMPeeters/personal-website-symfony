<?php

namespace App\Form;

use App\Entity\SupportedLanguage;
use App\Component\Config\LanguagesEnum;
use Symfony\Component\Form\AbstractType;
use App\Repository\SupportedLanguageRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SupportedLanguageType extends AbstractType
{
	public function __construct(
		private SupportedLanguageRepository $slRepo
	) {}
	
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		$choices = array_combine(
			array_column(LanguagesEnum::cases(), 'name'),
			array_column(LanguagesEnum::cases(), 'value'),
		);
		
		foreach($this->slRepo->findAll() as $language) {
			$code = $language->getCountryCode();
			
			if(isset($choices[$code])) {
				unset($choices[$code]);
			}
		}
		
        $builder
			->add('countryCode', ChoiceType::class, [
				'choices' => array_flip($choices),
			])
			->add('main', CheckboxType::class, [
				'required' => false,
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SupportedLanguage::class,
        ]);
    }
}
