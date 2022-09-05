<?php

namespace App\Component\Pages\FormType\Data;

use App\Form\HotlinkType;
use App\Entity\AbstractPageData;
use App\Entity\SupportedLanguage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AbstractPageDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
			->add('title', TextType::class)
			->add('navName', TextType::class, [
				'help' => 'This name will appear on short links and buttons.'
			])
			->add('hotlink', HotlinkType::class)
			->add('metaDescription', TextareaType::class)
		;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AbstractPageData::class,
			'supportedLanguage' => null,
        ]);
    }
}
