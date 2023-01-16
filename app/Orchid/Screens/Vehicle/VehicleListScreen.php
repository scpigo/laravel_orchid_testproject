<?php

namespace App\Orchid\Screens\Vehicle;

use App\Models\Vehicle;
use App\Orchid\Layouts\Vehicle\VehicleListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class VehicleListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'vehicles' => Vehicle::filters()->defaultSort('brand')->paginate()
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
        return 'Транспортные средства';
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
                ->route('platform.vehicle.create'),
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
            VehicleListLayout::class
        ];
    }

    public function remove(Vehicle $vehicle, Request $request): void
    {
        Vehicle::findOrFail($request->get('id'))->delete();

        Toast::info('Запись удалена!');
    }
}
