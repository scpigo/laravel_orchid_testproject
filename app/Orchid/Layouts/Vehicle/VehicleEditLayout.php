<?php

namespace App\Orchid\Layouts\Vehicle;

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

class VehicleEditLayout extends Rows
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
            Input::make('vehicle.brand')
                ->title('Марка')
                ->required(),
            Input::make('vehicle.color')
                ->title('Цвет')
                ->type('color')
                ->required(),
            Picture::make('vehicle.photo')
                ->title('Фото')
                ->required()
                ->acceptedFiles('.jpg, .png')
                ->storage('public')
                ->targetRelativeUrl(),
            Input::make('vehicle.government_number')
                ->title('Госномер')
                ->required(),
            Select::make('drivers')
                ->fromModel(Driver::class, 'full_name')
                ->title('Водители')
                ->multiple()
        ];
    }
}
