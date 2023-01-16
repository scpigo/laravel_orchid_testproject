<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make('Водители')
                ->icon('note')
                ->route('platform.driver')
                ->permission('platform.systems.drivers')
                ->title('Общее'),

            Menu::make('Транспортные средства')
                ->icon('note')
                ->route('platform.vehicle')
                ->permission('platform.systems.vehicles'),

            Menu::make('Путевые листы')
                ->icon('note')
                ->route('platform.waybill')
                ->permission('platform.systems.waybills.admin'),


            Menu::make('Пользователи')
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title('Права доступа'),

            Menu::make('Роли')
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make(__('Profile'))
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users'))
                ->addPermission('platform.systems.waybills', 'Путевые листы')
                ->addPermission('platform.systems.waybills.admin', 'Путевые листы для админов')
                ->addPermission('platform.systems.vehicles', 'Транспортные средства')
                ->addPermission('platform.systems.drivers', 'Водители')
        ];
    }
}
