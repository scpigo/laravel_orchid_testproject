<?php

namespace App\Orchid\Screens\Waybill;

use App\Models\Classification;
use App\Models\Waybill;
use App\Orchid\Layouts\Waybill\WaybillEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use function redirect;

class WaybillEditScreen extends Screen
{
    public $waybill;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Waybill $waybill): iterable
    {
        return [
            'waybill' => $waybill
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.waybills'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->waybill->exists ? 'Редактировать' : 'Добавить';
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
                ->canSee(!$this->waybill->exists),

            Button::make('Обновить')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->waybill->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->waybill->exists),
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
            WaybillEditLayout::class
        ];
    }

    public function createOrUpdate(Waybill $waybill, Request $request): RedirectResponse
    {
        $waybill->fill($request->get('waybill'));

        if (!Auth::user()->hasAccess('platform.systems.waybills.admin')) {
            $waybill->responsible_id = Auth::id();
        }

        $classifications = preg_replace('/\s*,\s*/', ',', $request->get('waybill')['classifications']);
        $classifications = explode(',', $classifications);

        foreach ($classifications as $word) {
            /** @var Classification $class */
            $class = Classification::query()->where('keyword', ucwords($word))->first();

            if (!$class) {
                $newclass = new Classification();

                $newclass->keyword = ucwords($word);

                $newclass->save();
            }
        }

        $waybill->save();

        Alert::info('Запись сохранена.');

        return redirect()->route(Auth::user()->hasAccess('platform.systems.waybills.admin') ? 'platform.waybill' : 'platform.main');
    }

    public function remove(Waybill $waybill): RedirectResponse
    {
        $waybill->delete();

        Alert::info('Запись удалена.');

        return redirect()->route(Auth::user()->hasAccess('platform.systems.waybills.admin') ? 'platform.waybill' : 'platform.main');
    }
}
