<?php namespace System\Classes;

use Illuminate\Routing\Controller as ControllerBase;

class Controller extends ControllerBase
{
    public function combine($name)
    {
        try {

            if (!strpos($name, '-')) {
                throw new ApplicationException("");
            }

            $parts = explode('-', $name);
            $cacheId = $parts[0];

            $combiner = CombineAssets::instance();
            return $combiner->getContents($cacheId);
        }
        catch (Exception $exception) {
            return '/* '.$exception->getMessage().' */';
        }
    }
}
