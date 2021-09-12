<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryBindingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }

    private function registerBindings()
    {
        $repos = [
            'Reconciliation'
        ];

        if (!empty($repos)) {
            foreach ($repos as $repo) {
                $this->app->bind("App\\Repositories\\{$repo}\\{$repo}Interface", "App\\Repositories\\{$repo}\\{$repo}Abstract");
            }
        }
    }
}
