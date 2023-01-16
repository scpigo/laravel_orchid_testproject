<?php

namespace App\Orchid\Layouts\Vehicle;

use App\Models\Driver;
use App\Models\DriverVehicle;
use App\Models\Vehicle;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class VehicleListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'vehicles';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('brand', 'Марка')
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('color', 'Цвет')
                ->render(function (Vehicle $vehicle) {
                    return Input::make($vehicle->color)
                        ->type('color')
                        ->value($vehicle->color)
                        ->disabled();
                }),
            TD::make('photo', 'Фото')
                ->render(function (Vehicle $vehicle) {
                    return "<img src='".asset($vehicle->photo)."' class='mw-100 d-block img-fluid rounded-1 w-100'>";;
                }),
            TD::make('government_number', 'Госномер')
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('', 'Водители')
                ->render(function (Vehicle $vehicle) {
                    $drivers = DriverVehicle::query()->where('vehicle_id', $vehicle->id)->get()->toArray();
                    $fields = [];

                    foreach ($drivers as $key => $item) {
                        $driver = Driver::query()->where('id', $item['driver_id'])->first();
                        $fields[] = Link::make($driver->full_name)
                            ->route('platform.driver.edit', $driver);
                    }

                    return Group::make($fields);
                }),
            TD::make('Действия')
                ->cantHide()
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Vehicle $vehicle) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make('Редактировать')
                                ->route('platform.vehicle.edit', $vehicle)
                                ->icon('pencil'),

                            Button::make('Удалить')
                                ->icon('trash')
                                ->confirm('Вы уверены, что хотите удалить запись?')
                                ->method('remove', [
                                    'id' => $vehicle->id,
                                ]),
                        ]);
                }),
        ];
    }
}
