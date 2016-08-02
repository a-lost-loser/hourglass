<?php namespace Hourglass\Core\Foundation\Providers;

use Illuminate\Support\Str;
use Blade;
use View;
use Hourglass\Core\Html\TemplateResolver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('template.resolver', function() {
            return TemplateResolver::instance();
        }, true);
    }

    public function boot()
    {
        Blade::directive('templateevent', function($event) {
            if (Str::startsWith($event, "(")) {
                $event = substr($event, 1, -1);
            }

            return "<?php echo TemplateResolver::resolve($event, \$__env, array_except(get_defined_vars(), ['__data', '__path'])); ?>";
        });

        Blade::directive('templatesection', function($section) {
            if (Str::startsWith($section, "(")) {
                $section = substr($section, 1, -1);
            }

            return "<?php if (TemplateResolver::addSection($section, get_defined_vars()) && TemplateResolver::isSectionEnabled($section)): ?>";
        });

        Blade::directive('endtemplatesection', function() {
            return "<?php endif; ?>";
        });
    }
}