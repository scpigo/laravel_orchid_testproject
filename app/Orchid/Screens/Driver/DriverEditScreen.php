<?php

namespace App\Orchid\Screens\Driver;

use App\Models\Driver;
use App\Models\DriverVehicle;
use App\Orchid\Layouts\Driver\DriverEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use function redirect;

class DriverEditScreen extends Screen
{
    public $driver;

    public function permission(): ?iterable
    {
        return [
            'platform.systems.drivers'
        ];
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Driver $driver): iterable
    {
        return [
            'driver' => $driver,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->driver->exists ? 'Редактировать' : 'Добавить';
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
                ->canSee(!$this->driver->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->driver->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->driver->exists),
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
            DriverEditLayout::class
        ];
    }

    public function createOrUpdate(Driver $driver, Request $request): RedirectResponse
    {
        $driver->fill($request->get('driver'));
        $driver->license = $request->get('driver')['license'][0];
        $driver->save();

        $vehicles = $request->get('vehicles');

        if (!empty($vehicles)) {
            $vehicles_old = DriverVehicle::query()->where('driver_id', $driver->id)->get();

            foreach ($vehicles_old as $vehicle) {
                $vehicle->delete();
            }

            foreach ($vehicles as $id) {
                $vehicle = new DriverVehicle();

                $vehicle->driver_id = $driver->id;
                $vehicle->vehicle_id = $id;

                $vehicle->save();
            }
        }

        Alert::info('Запись сохранена.');

        return redirect()->route('platform.driver');
    }

    public function remove(Driver $driver): RedirectResponse
    {
        $driver->delete();

        Alert::info('Запись удалена.');

        return redirect()->route('platform.driver');
    }
}
