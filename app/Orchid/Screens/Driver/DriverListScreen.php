<?php

namespace App\Orchid\Screens\Driver;

use App\Models\Driver;
use App\Orchid\Layouts\Driver\DriverListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class DriverListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'drivers' => Driver::filters()->defaultSort('full_name')->paginate(),
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.drivers'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Водители';
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
                ->route('platform.driver.create'),
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
            DriverListLayout::class
        ];
    }

    public function remove(Driver $driver, Request $request): void
    {
        Driver::findOrFail($request->get('id'))->delete();

        Toast::info('Запись удалена!');
    }
}
