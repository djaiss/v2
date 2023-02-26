<?php

namespace App\Domains\Settings\ManageCompany\Jobs;

use App\Models\Company;
use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetupCompany implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Company $company
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
    }

    private function createRoles(): void
    {
        $role = Role::create([
            'company_id' => $this->company->id,
            'translation_key' => 'Administrator',
        ]);
    }
}
