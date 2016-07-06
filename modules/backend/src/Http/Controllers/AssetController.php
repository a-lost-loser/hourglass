<?php namespace Communalizer\Backend\Http\Controllers;

use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Communalizer\Core\Plugin\PluginManager;

class AssetController extends Controller
{
    protected function getAssetList()
    {
        $pluginList = PluginManager::instance()->getPluginList();
        $result = [];

        foreach ($pluginList as $plugin) {
            if (!$plugin['assets']) {
                continue;
            }

            foreach ($plugin['assets'] as $category => $assets) {
                if (!isset($result[$category])) {
                    $result[$category] = [];
                }

                // If it is a single asset, turn it into an array
                if (!is_array($assets)) {
                    $assets = [$assets];
                }

                foreach ($assets as $asset) {
                    $result[$category][] = $plugin['paths']['files'] . $asset;
                }
            }
        }

        return $result;
    }
    
    public function stylesheet()
    {
        $css = $this->getAssetList()['css'];

        return $css;
    }

    /**
     *
     * @return string
     */
    public function javascript()
    {
        $javascript = $this->getAssetList()['js'];

        $assets = [];
        foreach ($javascript as $path) {
            if (!file_exists($path))
                continue; // Or throw an exception, or log
            
            $assets[] = new FileAsset($path);
        }

        $scripts = new AssetCollection($assets);

        return $scripts->dump();
    }
}