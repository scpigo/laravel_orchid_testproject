<?php

namespace App\Orchid\Layouts\Waybill;

use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;
use App\Orchid\Fields\Adress;
use App\Orchid\Fields\Classification;
use App\Orchid\Fields\DadataInput;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\TD;

class WaybillEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('waybill.registration_number')
                ->title('Номер регистрации')
                ->required(),
            DateTimer::make('waybill.issued_at')
                ->title('Дата назначения')
                ->format('Y-m-d')
                ->required(),
            Input::make('waybill.valid_for_days')
                ->title('Кол-во дней')
                ->type('number')
                ->required(),
            Relation::make('waybill.driver_id')
                ->fromModel(Driver::class, 'full_name')
                ->title('Выберите водителя')
                ->required(),
            Relation::make('waybill.vehicle_id')
                ->fromModel(Vehicle::class, 'brand')
                ->title('Выберите транспортное средство')
                ->required(),
            Adress::make('waybill.route_from')
                ->title('Маршрут: от')
                ->required(),
            Adress::make('waybill.route_to')
                ->title('Маршрут: до')
                ->required(),
            Relation::make('waybill.responsible_id')
                ->fromModel(User::class, 'name')
                ->title('Выберите ответственного')
                ->canSee(Auth::user()->hasAccess('platform.systems.waybills.admin'))
                ->required(),
            Select::make('waybill.status')
                ->options([
                    0   => 'Неактивен',
                    1 => 'Активен',
                ])
                ->title('Статус')
                ->required(),
            Classification::make('waybill.classifications')
                ->title('Классификация')
                ->required(),
        ];
    }
}
