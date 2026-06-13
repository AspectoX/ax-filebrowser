<?php

namespace AspectoX\AxFileBrowser;

use Illuminate\Support\ServiceProvider;

class AxFileBrowserServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // ── Rutas ─────────────────────────────────────────────────────────────
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // ── Vistas ────────────────────────────────────────────────────────────
        $this->loadViewsFrom(__DIR__ . '/../resources/views/ax-filebrowser', 'ax-filebrowser');

        // ── Idiomas ───────────────────────────────────────────────────────────
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'ax-filebrowser');

        // Registrar traducciones sin namespace para __('ax-filebrowser.key')
        $locale   = app()->getLocale();
        $fallback = app()->getFallbackLocale();
        foreach ([$locale, $fallback, 'en'] as $lang) {
            $file = __DIR__ . '/../lang/' . $lang . '/ax-filebrowser.php';
            if (file_exists($file)) {
                app('translator')->addLines(
                    collect(require $file)->mapWithKeys(fn($v, $k) => ["ax-filebrowser.{$k}" => $v])->all(),
                    $lang
                );
                break;
            }
        }

        // ── Migraciones ───────────────────────────────────────────────────────
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // ── Publicables ───────────────────────────────────────────────────────
        if ($this->app->runningInConsole()) {

            // Config
            $this->publishes([
                __DIR__ . '/../config/ax-filebrowser.php' => config_path('ax-filebrowser.php'),
            ], 'ax-filebrowser-config');

            // Assets (CSS, JS)
            $this->publishes([
                __DIR__ . '/../public' => public_path('vendor/ax-filebrowser'),
            ], 'ax-filebrowser-assets');

            // Vistas (para personalizar)
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/ax-filebrowser'),
            ], 'ax-filebrowser-views');

            // Idiomas (para personalizar)
            $this->publishes([
                __DIR__ . '/../lang' => lang_path('vendor/ax-filebrowser'),
            ], 'ax-filebrowser-lang');

            // Todo junto
            $this->publishes([
                __DIR__ . '/../config/ax-filebrowser.php' => config_path('ax-filebrowser.php'),
                __DIR__ . '/../public'                    => public_path('vendor/ax-filebrowser'),
            ], 'ax-filebrowser');
        }
    }

    public function register(): void
    {
        // Merge config — usa los valores del package si el usuario no publicó el config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/ax-filebrowser.php',
            'ax-filebrowser'
        );
    }
}