<?php

namespace App\Domains\Layout\Web\ViewHelpers;

class LayoutViewHelper
{
    public static function data(): array
    {
        $localesCollection = collect();
        $localesCollection->push([
            'name' => 'English',
            'url' => route('locale.update', ['locale' => 'en']),
        ]);
        $localesCollection->push([
            'name' => 'Français',
            'url' => route('locale.update', ['locale' => 'fr']),
        ]);

        return [
            'locales' => $localesCollection,
        ];
    }
}
