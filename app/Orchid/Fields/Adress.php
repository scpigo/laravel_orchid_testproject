<?php

namespace App\Orchid\Fields;

use Orchid\Screen\Field;

class Adress extends Field
{
    protected $view = 'fields.adress';

    protected $attributes = [];

    protected $inlineAttributes = [
        'name',
        'title',
        'required'
    ];
}
