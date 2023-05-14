<?php

namespace Tests\Unit\Domains\Layout\Web\ViewHelpers;

use App\Domains\Layout\Web\ViewHelpers\LayoutViewHelper;
use App\Models\Company;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LayoutViewHelperTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_view(): void
    {
        Carbon::setTestNow(Carbon::create(2023, 1, 1));
        $company = Company::factory()->create([
            'name' => 'Company name',
        ]);
        $employee = Employee::factory()->create([
            'company_id' => $company->id,
        ]);
        $this->be($employee);

        $array = LayoutViewHelper::data();

        $this->assertEquals(
            5,
            count($array)
        );

        $this->assertArrayHasKey('currentLocale', $array);
        $this->assertArrayHasKey('locales', $array);
        $this->assertArrayHasKey('currentYear', $array);
        $this->assertArrayHasKey('company', $array);

        $this->assertEquals(
            'en',
            $array['currentLocale']
        );
        $this->assertEquals(
            [
                0 => [
                    'name' => 'English',
                    'shortCode' => 'en',
                    'url' => config('app.url').'/locale/en',
                ],
                1 => [
                    'name' => 'Français',
                    'shortCode' => 'fr',
                    'url' => config('app.url').'/locale/fr',
                ],
            ],
            $array['locales']->toArray()
        );
        $this->assertEquals(
            2023,
            $array['currentYear']
        );
        $this->assertEquals(
            [
                'name' => 'Company name',
            ],
            $array['company']
        );
        $this->assertEquals(
            [
                'search' => env('APP_URL').'/search',
            ],
            $array['url']
        );
    }
}
