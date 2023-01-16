<?php

namespace App\Orchid\Fields;

use Orchid\Screen\Field;

class Classification extends Field
{
    protected $view = 'fields.classification';

    protected $attributes = [];

    protected $inlineAttributes = [
        'name',
        'title',
        'required'
    ];
}
