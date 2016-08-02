<?php namespace Hourglass\Core\File;

use Illuminate\Filesystem\Filesystem as FilesystemBase;

class Filesystem extends FilesystemBase
{
    public $filePermissions = null;

    public $folderPermissions = null;

    public $pathSymbols = [];

    public function normalizePath($path)
    {
        return str_replace('\\', '/', $path);
    }

}