<?php

namespace App\Orchid\Layouts\Driver;

use App\Models\Driver;
use App\Models\Vehicle;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\TD;

class DriverEditLayout extends Rows
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
            Input::make('driver.full_name')
                ->title('Имя')
                ->required(),
            DateTimer::make('driver.birthdate')
                ->title('Дата рождения')
                ->format('Y-m-d')
                ->required(),
            Picture::make('driver.photo')
                ->title('Фото')
                ->required()
                ->acceptedFiles('.jpg, .png')
                ->storage('public')
                ->targetRelativeUrl(),
            Upload::make('driver.license')
                ->groups('documents')
                ->title('Водительское удостоверения')
                ->maxFiles(1)
                ->acceptedFiles('application/pdf')
                ->storage('public')
                ->required(),
            Input::make('driver.license_series')
                ->title('Серия удостоверения')
                ->required(),
            Input::make('driver.license_id')
                ->title('Номер удостоверения')
                ->required(),
            DateTimer::make('driver.license_get_date')
                ->title('Дата получения удостоверения')
                ->format('Y-m-d')
                ->required(),
            Select::make('vehicles')
                ->fromModel(Vehicle::class, 'brand')
                ->title('Транспортные средства')
                ->multiple()
        ];
    }
}
