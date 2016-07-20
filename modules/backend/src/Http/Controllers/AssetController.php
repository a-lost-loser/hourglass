<?php namespace Hourglass\Backend\Http\Controllers;

use Assetic\Asset\AssetCache;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Cache\FilesystemCache;
use Assetic\Filter\CssMinFilter;
use Assetic\Filter\JSMinFilter;
use Assetic\Filter\JSqueezeFilter;
use Hourglass\Core\Plugin\PluginManager;

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

        $assets = [new FileAsset(base_path('assets/css/app.css'))];
        foreach ($css as $path) {
            if (!file_exists($path))
                continue; // Or throw an exception, or log

            $assets[] = new FileAsset($path);
        }

        $cachePath = storage_path('framework/cache/css');
        $collection = new AssetCollection();
        $cache = new FilesystemCache($cachePath);

        foreach ($assets as $asset) {
            $cachedAsset = new AssetCache($asset, $cache);
            $collection->add($cachedAsset);
        }

        $publicPath = $cachePath . '/' . 'public';
        if (!file_exists($publicPath) || $collection->getLastModified() > filemtime($publicPath)) {
            file_put_contents($publicPath, $collection->dump());
        }

        return response(file_get_contents($publicPath))->header('Content-Type', 'text/css');
    }

    /**
     *
     * @return string
     */
    public function javascript()
    {
        $javascript = $this->getAssetList()['js'];

        $assets = [new FileAsset(base_path('assets/js/app.js'))];
        foreach ($javascript as $path) {
            if (!file_exists($path))
                continue; // Or throw an exception, or log

            $assets[] = new FileAsset($path);
        }

        $cachePath = storage_path('framework/cache/javascript');
        $collection = new AssetCollection();
        $cache = new FilesystemCache($cachePath);

        foreach ($assets as $asset) {
            $cachedAsset = new AssetCache($asset, $cache);
            $collection->add($cachedAsset);
        }

        $publicPath = $cachePath . '/' . 'public';
        if (!file_exists($publicPath) || $collection->getLastModified() > filemtime($publicPath)) {
            file_put_contents($publicPath, $collection->dump());
        }

        return response(file_get_contents($publicPath))->header('Content-Type', 'application/javascript');
    }
}