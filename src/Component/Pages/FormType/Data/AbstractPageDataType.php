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

class AbstractPageDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
			->add('title', TextType::class)
			->add('supportedLanguage', EntityType::class, [
				'class' => SupportedLanguage::class,
			])
			->add('hotlink', HotlinkType::class)
		;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AbstractPageData::class,
        ]);
    }
}
