<?php

namespace App\Orchid\Screens\Waybill;

use App\Models\Waybill;
use App\Orchid\Layouts\Waybill\WaybillListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class WaybillListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'waybills' => Waybill::filters()->defaultSort('registration_number')->paginate()
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.vehicles'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Путевые листы';
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
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            WaybillListLayout::class
        ];
    }
}
