<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class FileRemover
{
    public function remove(string $fileName): bool
    {
		$fs = new Filesystem();
		
		if($fs->exists($fileName)) {
			try {
				$fs->remove($fileName);
				
				return true;
			} catch(FileException $e) {
				return false;
			}
		}
		
		return false;
    }
}
