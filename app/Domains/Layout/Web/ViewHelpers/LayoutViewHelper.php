<?php

namespace App\Domains\Layout\Web\ViewHelpers;

use App\Helpers\ContactCardHelper;
use App\Helpers\MapHelper;
use App\Helpers\WikipediaHelper;
use App\Models\Contact;
use App\Models\Vault;
use Illuminate\Support\Str;

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
