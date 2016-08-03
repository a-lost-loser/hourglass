<?php namespace Hourglass\Support\Filters;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;

/**
 * Importer JS Filter
 * Class used to import referenced javascript files.
 *
 * @package surgeonboard/nurse
 * @author Christopher M�hl
 */
class JavascriptImporter implements FilterInterface
{

    /**
     * @var string Location of where the processd JS script resides.
     */
    protected $scriptPath;

    /**
     * @var string File name for the processed JS script.
     */
    protected $scriptFile;

    /**
     * @var array Cache of required files.
     */
    protected $includedFiles = [];

    /**
     * @var array Variables defined by this script.
     */
    protected $definedVars = [];

    /**
     * Filters an asset after it has been loaded.
     *
     * @param AssetInterface $asset An asset.
     */
    public function filterLoad(AssetInterface $asset)
    {
    }

    /**
     * Filters an asset just before it's dumped.
     *
     * @param AssetInterface $asset An asset.
     */
    public function filterDump(AssetInterface $asset)
    {
        $this->scriptPath = dirname($asset->getSourceRoot() . '/' . $asset->getSourcePath());
        $this->scriptFile = basename($asset->getSourcePath());

        $asset->setContent($this->parse($asset->getContent()));
    }

    /**
     * Process JS imports inside a string of javascript.
     * @param $content string JS code to process.
     * @return string Processed JS.
     */
    protected function parse($content)
    {
        return $content;
    }
}