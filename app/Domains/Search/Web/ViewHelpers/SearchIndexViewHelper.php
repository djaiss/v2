<?php

namespace App\Domains\Search\Web\ViewHelpers;

use App\Models\Company;
use App\Models\Office;
use Illuminate\Support\Collection;

class SearchIndexViewHelper
{
    public static function data(Company $company, string $term = null): array
    {
        return [
            'offices' => $term ? self::offices($company, $term) : [],
        ];
    }

    private static function offices(Company $company, string $term): Collection
    {
        /** @var Collection<int, Office> */
        $offices = Office::search($term)
            ->where('company_id', $company->id)
            ->get();

        return $offices->map(fn (Office $office) => [
            'id' => $office->id,
            'name' => $office->name,
        ]);
    }
}
