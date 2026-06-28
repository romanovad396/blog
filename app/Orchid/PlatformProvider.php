<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);
    }

    public function menu(): array
    {
        return [
            Menu::make('Главная')
                ->icon('bs.house')
                ->route(config('platform.index'))
                ->title('Навигация'),

            Menu::make('Пользователи')
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users'),

            Menu::make('Публикации')
                ->icon('bs.journal-text')
                ->route('platform.systems.posts')
                ->permission('platform.systems.posts'),
        ];
    }

    public function permissions(): array
    {
        return [
            ItemPermission::group('Система')
                ->addPermission('platform.systems.users', 'Пользователи')
                ->addPermission('platform.systems.posts', 'Публикации'),
        ];
    }
}
