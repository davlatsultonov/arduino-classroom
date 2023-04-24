<?php

namespace App\Providers;

use App\Nova\Article;
use App\Nova\Category;
use App\Nova\SubCategory;
use App\Nova\Test;
use App\Nova\TestAnswer;
use App\Nova\TestQuestion;
use App\Nova\User;
use \App\Nova\Dashboards\Main;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::withoutNotificationCenter();
        $this->getFooterContent();
        $this->getCustomMenu();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function getFooterContent(): void
    {
        Nova::footer(function () {
            return Blade::render('nova/footer');
        });
    }

    private function getCustomMenu() {
        Nova::mainMenu(function () {
            return [
                MenuSection::dashboard(Main::class)->icon('presentation-chart-bar'),
                MenuSection::resource(User::class)->icon('user'),
                MenuSection::resource(Article::class)->icon('document-text'),
                MenuSection::resource(Category::class)->icon('view-grid-add'),
                MenuSection::resource(SubCategory::class)->icon('view-grid-add'),
                MenuSection::make('Tests', [
                    MenuItem::resource(Test::class),
                    MenuItem::resource(TestQuestion::class),
                    MenuItem::resource(TestAnswer::class),
                ])->collapsable()->icon('light-bulb')
            ];
        });
    }
}
