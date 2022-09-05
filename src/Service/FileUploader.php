<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
		private string $imageDirectory,
		private SluggerInterface $slugger
		) {}

    public function upload(UploadedFile $file): false|string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
		
        try {
            $file->move($this->getimageDirectory(), $fileName);
        } catch (FileException $e) {
			return false;
        }

        return $fileName;
    }

    public function getimageDirectory()
    {
        return $this->imageDirectory;
    }
}
