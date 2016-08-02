<?php namespace Hourglass\Core\Plugin\Console;

use Hourglass\Core\Plugin\PluginManager;
use Hourglass\Core\Plugin\PluginRepository;
use Illuminate\Console\Command;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Symfony\Component\Console\Input\InputOption;

class InstallCommand extends Command
{
    /**
     * The name and signature of the command.
     *
     * @var string
     */
    protected $signature = 'plugin:install
                            {identifier : The identifier of the plugin that should be installed (e.g. \'Hourglass.Demo\')}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install a plugin';

    /**
     * Create a new migration install command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    const INSTALLED = 1;
    const NOT_FOUND = 2;
    const ALREADY_INSTALLED = 3;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $plugins = PluginManager::instance()->getPluginList(true);
        $identifier = $this->argument('identifier');

        $installed = self::NOT_FOUND;
        foreach ($plugins as $element) {
            if ($element['identifier'] != $identifier)
                continue;

            $plugin = $element['object'];
            $installerClass = $plugin->installer;
            $installer = new $installerClass;

            $installer->install($plugin);

            if ($plugin->isInstalled()) {
                $installed = self::ALREADY_INSTALLED;
            } else {
                $plugin->installPlugin();
                $installed = self::INSTALLED;
                break;
            }
        }

        switch ($installed) {
            case self::ALREADY_INSTALLED:
                $this->info('The plugin <comment>' . $identifier . '</comment> was already installed.');
                return;
            case self::NOT_FOUND:
                $this->error('The plugin "' . $identifier . '" could not be found.');
                return;
            default:
                $this->info('Installed plugin <comment>' . $identifier . '</comment>.');
                return;
        }
    }
}