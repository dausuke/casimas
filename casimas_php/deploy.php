<?php
namespace Deployer;
require 'recipe/common.php';

// Configuration

set('ssh_type', 'native');
set('ssh_multiplexing', true);
set('application', 'casimas');

set('repository', 'git@github.com:dausuke/casimas.git');
set('shared_files', []);
set('shared_dirs', []);
set('writable_dirs', []);

set('allow_anonymous_stats', false);
set('git_tty', false);

// Servers

// host('staging', 'ssh-1.mc.lolipop.jp')
//     ->port('35983')
//     ->user('curly-hyuga-4977')
//     ->identityFile('/Users/daisuke/.ssh/id_rsa')
//     ->set('deploy_path', '/var/www/html')
//     //->set('branch', 'master')
serverList('hosts.yml');
//inventory('hosts.yml');

// Tasks

desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    // The user must have rights for restart service
    // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
    run('sudo systemctl restart php-fpm.service');
});
after('deploy:symlink', 'php-fpm:restart');

desc('Deploy your project');
task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');