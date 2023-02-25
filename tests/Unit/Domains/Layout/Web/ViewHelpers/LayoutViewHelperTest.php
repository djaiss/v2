<?php

namespace Tests\Unit\Domains\Layout\Web\ViewHelpers;

use App\Domains\Layout\Web\ViewHelpers\LayoutViewHelper;
use Carbon\Carbon;
use function env;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LayoutViewHelperTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_view(): void
    {
        Carbon::setTestNow(Carbon::create(2023, 1, 1));
        $array = LayoutViewHelper::data();

        $this->assertEquals(
            2,
            count($array)
        );

        $this->assertArrayHasKey('locales', $array);
        $this->assertArrayHasKey('currentYear', $array);

        $this->assertEquals(
            [
                0 => [
                    'name' => 'English',
                    'url' => env('APP_URL').'/locale/en',
                ],
                1 => [
                    'name' => 'Français',
                    'url' => env('APP_URL').'/locale/fr',
                ],
            ],
            $array['locales']->toArray()
        );
        $this->assertEquals(
            2023,
            $array['currentYear']
        );
    }
}
