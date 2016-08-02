<?php namespace Hourglass\Core\File;

use Illuminate\Filesystem\FilesystemServiceProvider as FilesystemServiceProviderBase;

class FilesystemServiceProvider extends FilesystemServiceProviderBase
{
    public function register()
    {
        $this->registerNativeFilesystem();

        $this->registerFlysystem();
    }

    protected function registerNativeFilesystem()
    {
        $this->app->singleton('files', function($app) {
            $config = $app['config'];
            $files = new Filesystem;
            $files->filePermissions = $config->get('board.defaultMask.file', null);
            $files->folderPermissions = $config->get('board.defaultMask.folder', null);
            $files->pathSymbols = [
                '$' => base_path() . $config->get('board.pluginsDir', '/plugins'),
                '~' => base_path(),
            ];

            return $files;
        });
    }

    public function provides()
    {
        return ['files', 'filesystem'];
    }
}