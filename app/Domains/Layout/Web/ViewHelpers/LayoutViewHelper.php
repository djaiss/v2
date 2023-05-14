<?php

namespace App\Domains\Layout\Web\ViewHelpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class LayoutViewHelper
{
    public static function data(): array
    {
        $localesCollection = collect();
        $localesCollection->push([
            'name' => 'English',
            'shortCode' => 'en',
            'url' => route('locale.update', ['locale' => 'en']),
        ]);
        $localesCollection->push([
            'name' => 'Français',
            'shortCode' => 'fr',
            'url' => route('locale.update', ['locale' => 'fr']),
        ]);

        // current company for the logged employee
        $company = null;
        if (auth()->check()) {
            $company = auth()->user()->company;
        }

        return [
            'currentLocale' => App::currentLocale(),
            'locales' => $localesCollection,
            'currentYear' => Carbon::now()->format('Y'),
            'company' => $company ? [
                'name' => $company->name,
            ] : null,
            'url' => [
                'search' => route('search.show'),
            ],
        ];
    }
}
