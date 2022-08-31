<?php

namespace App\Component\Pages\FormType\Page;

use App\Entity\AbstractPage;
use Symfony\Component\Form\AbstractType;
use App\Repository\SupportedLanguageRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AbstractPageType extends AbstractType
{
	protected array $supportedLanguages;
	
	public function __construct(
		private SupportedLanguageRepository $slRepo
	) {
		$this->supportedLanguages = $this->slRepo->findAll();
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
			->add('identifier', TextType::class)
			->add('addToNav', CheckboxType::class)
			->add('public', CheckboxType::class)
		;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AbstractPage::class,
        ]);
    }
}
