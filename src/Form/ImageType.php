<?php

namespace App\Form;

use App\Entity\Image;
use App\Service\FileUploader;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageType extends AbstractType
{
	public function __construct(
		private FileUploader $fileUploader,
		private string $publicImageDir
	) {}
	
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
			->add('image', FileType::class, [
				'required' => false,
				'mapped' => false,
			])
		;
		
		// $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
		// 	$data = $event->getData();
		// 	$form = $event->getForm();
		// 	dd($form->getParent()->getData());
		// 	if($data instanceof UploadedFile) {
		// 		$newImage = new Image();
		// 		dd($event->getParent()->getData());
		// 		$newImage->setFileName($this->fileUploader->upload($data['image']));
				
		// 		$event->setData(['image' => $newImage]);
				
				
		// 	}
		// });
    }
}
