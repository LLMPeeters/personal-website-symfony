<?php

namespace App\Component\Widgets\FormType\Widget;

use App\Entity\AbstractWidget;
use App\Service\CreateNewDataSets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AbstractWidgetType extends AbstractType
{
	public function __construct(
		private CreateNewDataSets $createSets
	) {}
	
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
		if(!isset($options['data']) || !$options['data'] instanceof AbstractWidget) {
			throw new \LogicException('The data option for AbstractWidgetType and its descendants should be set to an AbstractWidgetType class.');
		}
		
		if(is_null($options['data']->getId())) {
			$this->createSets->createForWidget($options['data']);
		}
		
        $builder
            ->add('identifier', TextType::class, [
				'help' => 'This is an internal name and users will not see this.',
			])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AbstractWidget::class,
        ]);
    }
}
