<?php
namespace Deployer;

require 'recipe/symfony.php';

// Config
set('repository', 'git@github.com:LLMPeeters/personal-website-symfony.git');

// Hosts
host('llmpeeters')
    ->set('remote_user', 'deployer_llm')
    ->set('deploy_path', '/var/www/deploys/llm');

// Tasks
task('npm:install', function() {
	cd('{{ release_path }}');
	run('npm install');
});
task('npm:run:build', function() {
	cd('{{ release_path }}');
	run('npm run build');
});
task('permissions:images_dir', function() {
	cd('{{ release_path }}');
	run('chmod u=gwx,g=gwx,o= public/images/');
	run('chgrp www-data public/images/');
});

// Hooks
after('deploy:failed', 'deploy:unlock');
after('deploy:vendors', 'npm:install');
after('npm:install', 'npm:run:build');
after('npm:run:build', 'permissions:images_dir');