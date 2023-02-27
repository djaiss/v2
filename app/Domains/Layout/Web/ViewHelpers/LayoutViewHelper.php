<?php

namespace App\Domains\Layout\Web\ViewHelpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

        // current company for the logged employee
        $company = null;
        if (Auth::check()) {
            $company = Auth::user()->company;
        }

        return [
            'locales' => $localesCollection,
            'currentYear' => Carbon::now()->format('Y'),
            'company' => $company ? [
                'name' => $company->name,
            ] : null,
        ];
    }
}
