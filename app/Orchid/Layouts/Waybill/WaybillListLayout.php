<?php

namespace App\Orchid\Layouts\Waybill;

use App\Models\Driver;
use App\Models\Waybill;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class WaybillListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'waybills';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('registration_number', 'Номер регистрации')
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('issued_at', 'Дата назначения')
                ->render(function (Waybill $waybill) {
                    return $waybill->issued_at->format('Y-m-d');
                })
                ->sort()
                ->filter(TD::FILTER_DATE),
            TD::make('valid_for_days', 'Кол-во дней')
                ->sort()
                ->filter(TD::FILTER_NUMBER_RANGE),
            TD::make('driver_id', 'Водитель')
                ->render(function (Waybill $waybill) {
                    return Link::make($waybill->driver->full_name)
                        ->route('platform.driver.edit', $waybill->driver);
                })
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('vehicle_id', 'Транспортное средство')
                ->render(function (Waybill $waybill) {
                    return Link::make($waybill->vehicle->brand)
                        ->route('platform.vehicle.edit', $waybill->vehicle);
                })
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('route_from', 'Маршрут: от')
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('route_to', 'Маршрут: до')
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('responsible_id', 'Ответственный')
                ->render(function (Waybill $waybill) {
                    return Link::make($waybill->responsible->name)
                        ->route('platform.systems.users.edit', $waybill->responsible);
                })
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('status', 'Статус')
                ->render(function (Waybill $waybill) {
                    if ($waybill->status) {
                        return 'Активен';
                    }
                    return 'Неактивен';
                })
                ->sort()
                ->filter(TD::FILTER_SELECT, [0 => 'Неактивен', 1 => 'Активен']),
            TD::make('classifications', 'Классификация')
                ->sort()
                ->filter(TD::FILTER_TEXT),
            TD::make('Действия')
                ->cantHide()
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Waybill $waybill) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make('Редактировать')
                                ->route('platform.waybill.edit', $waybill)
                                ->icon('pencil'),

                            Button::make('Удалить')
                                ->icon('trash')
                                ->confirm('Вы уверены, что хотите удалить запись?')
                                ->method('remove', [
                                    'id' => $waybill->id,
                                ]),
                        ]);
                }),
        ];
    }
}
