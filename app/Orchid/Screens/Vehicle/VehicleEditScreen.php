<?php

namespace App\Orchid\Screens\Vehicle;

use App\Models\DriverVehicle;
use App\Models\Vehicle;
use App\Orchid\Layouts\Vehicle\VehicleEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use function redirect;

class VehicleEditScreen extends Screen
{
    public $vehicle;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Vehicle $vehicle): iterable
    {
        return [
            'vehicle' => $vehicle
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
        return $this->vehicle->exists ? 'Редактировать' : 'Добавить';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать')
                ->icon('plus')
                ->method('createOrUpdate')
                ->canSee(!$this->vehicle->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->vehicle->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->vehicle->exists),
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
            VehicleEditLayout::class
        ];
    }

    public function createOrUpdate(Vehicle $vehicle, Request $request): RedirectResponse
    {
        $vehicle->fill($request->get('vehicle'));
        $vehicle->save();

        $drivers = $request->get('drivers');

        if (!empty($drivers)) {
            $drivers_old = DriverVehicle::query()->where('vehicle_id', $vehicle->id)->get();

            foreach ($drivers_old as $driver) {
                $driver->delete();
            }

            foreach ($drivers as $id) {
                $driver = new DriverVehicle();

                $driver->vehicle_id = $vehicle->id;
                $driver->driver_id = $id;

                $driver->save();
            }
        }


        Alert::info('Запись сохранена.');

        return redirect()->route('platform.vehicle');
    }

    public function remove(Vehicle $vehicle): RedirectResponse
    {
        $vehicle->delete();

        Alert::info('Запись удалена.');

        return redirect()->route('platform.vehicle');
    }
}
