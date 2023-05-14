<?php

namespace Tests\Unit\Models;

use App\Models\IssueType;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class IssueTypeTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_belongs_to_one_organization()
    {
        $issueType = IssueType::factory()->create();

        $this->assertTrue($issueType->organization()->exists());
    }

    /** @test */
    public function it_gets_the_default_label()
    {
        $issueType = IssueType::factory()->create([
            'label' => null,
            'label_translation_key' => 'default label',
        ]);

        $this->assertEquals(
            'default label',
            $issueType->label
        );
    }

    /** @test */
    public function it_gets_the_custom_label_if_defined()
    {
        $issueType = IssueType::factory()->create([
            'label' => 'this is the real label',
            'label_translation_key' => 'default label',
        ]);

        $this->assertEquals(
            'this is the real label',
            $issueType->label
        );
    }
}
