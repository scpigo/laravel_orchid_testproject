<?php

namespace App\Orchid\Layouts\Driver;

use App\Models\Driver;
use App\Models\DriverVehicle;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DriverListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'drivers';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('full_name', 'Имя')
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('birthdate', 'Дата рождения')
                ->render(function (Driver $driver) {
                    return $driver->birthdate->format('Y-m-d');
                })
                ->sort()
                ->filter(TD::FILTER_DATE),
            TD::make('photo', 'Фото')
                ->render(function (Driver $driver) {
                    return "<img src='".asset($driver->photo)."' class='mw-100 d-block img-fluid rounded-1 w-100'>";
                }),
            TD::make('license', 'Водительское удостоверение')
                ->render(function (Driver $driver) {
                    $license = Attachment::query()->find($driver->license);
                    return Link::make($license->original_name)
                        ->href(asset('/storage/'.$license->path.$license->name.'.'.$license->extension))
                        ->download($license->original_name);
                }),
            TD::make('license_series', 'Серия')
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('license_id', 'Номер')
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('license_get_date', 'Дата получения')
                ->render(function (Driver $driver) {
                    return $driver->license_get_date->format('Y-m-d');
                })
                ->sort()
                ->filter(TD::FILTER_DATE),
            TD::make('', 'Транспортные средства')
                ->render(function (Driver $driver) {
                    $vehicles = DriverVehicle::query()->where('driver_id', $driver->id)->get()->toArray();
                    $fields = [];

                    foreach ($vehicles as $key => $item) {
                        $vehicle = Vehicle::query()->where('id', $item['vehicle_id'])->first();
                        $fields[] = Link::make($vehicle->brand)
                            ->route('platform.vehicle.edit', $vehicle);
                    }

                    return Group::make($fields);
                }),
            TD::make('Действия')
                ->cantHide()
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Driver $driver) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make('Редактировать')
                                ->route('platform.driver.edit', $driver)
                                ->icon('pencil'),

                            Button::make('Удалить')
                                ->icon('trash')
                                ->confirm('Вы уверены, что хотите удалить запись?')
                                ->method('remove', [
                                    'id' => $driver->id,
                                ]),
                        ]);
                }),
        ];
    }
}
