<?php

namespace App\Providers;

use Code16\Sharp\Config\SharpConfigBuilder;
use Code16\Sharp\SharpAppServiceProvider;

class SharpServiceProvider extends SharpAppServiceProvider
{
    protected function configureSharp(SharpConfigBuilder $config): void
    {
        $config
            ->setName('My new project')
            ->setCustomUrlSegment('admin/sharp')
            ->discoverEntities();
    }

    protected function declareAccessGate(): void
    {
//        Gate::define('viewSharp', function ($user) {
//            return $user->is_sharp_admin;
//        });
    }
}
