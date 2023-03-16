<?php

namespace Tests\Unit\Domains\Settings\ManageOffices\Web\ViewHelpers;

use App\Domains\Settings\ManageOffices\Web\ViewHelpers\SettingsOfficeIndexViewHelper;
use App\Models\Company;
use App\Models\Permission;
use App\Models\office;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SettingsOfficeIndexViewHelperTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $company = Company::factory()->create();
        $office = Office::create([
            'company_id' => $company->id,
            'name' => 'HQ',
        ]);

        $viewModel = SettingsOfficeIndexViewHelper::data($company);

        $this->assertArrayHasKey('offices', $viewModel);
    }

    /** @test */
    public function it_gets_the_data_needed_for_the_office(): void
    {
        $company = Company::factory()->create();
        $office = Office::create([
            'company_id' => $company->id,
            'name' => 'HQ',
        ]);

        $array = SettingsOfficeIndexViewHelper::dto($office);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);

        $this->assertEquals(
            $office->id,
            $array['id']
        );
        $this->assertEquals(
            'HQ',
            $array['name']
        );
    }
}
