<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\Waybill;
use App\Orchid\Layouts\Waybill\WaybillListLayout;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'waybills' => Waybill::query()->where('responsible_id', Auth::id())->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return Auth::user()->hasAccess('platform.systems.waybills.admin') ? 'Главная' : 'Путевые листы';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить запись')
                ->icon('plus')
                ->route('platform.waybill.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return Auth::user()->hasAccess('platform.systems.waybills.admin') ? [] : [WaybillListLayout::class];
    }
}
