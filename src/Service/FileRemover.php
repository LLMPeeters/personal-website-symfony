<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class FileRemover
{
    public function remove(string $fileName): ?bool
    {
		$fs = new Filesystem();
		
		// If upload went wrong, then fileName could be falsy
		if($fileName !== '' && $fs->exists($fileName)) {
			try {
				$fs->remove($fileName);
				
				return true;
			} catch(FileException $e) {
				return null;
			}
		}
		
		return false;
    }
}
