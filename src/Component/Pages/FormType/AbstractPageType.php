<?php

namespace App\Component\Pages\FormType;

use App\Form\HotlinkType;
use App\Entity\AbstractPage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AbstractPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('identifier', TextType::class, [
				'help' => 'This is an internal name and users will not see this.',
			])
			->add('addToNav', CheckboxType::class)
            ->add('hotlink', HotlinkType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AbstractPage::class,
        ]);
    }
}
